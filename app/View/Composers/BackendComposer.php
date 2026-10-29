<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\General;
use App\Models\Services;
use App\Models\FooterGroup;
use App\Models\GalleryImage;
use App\Models\Font;
use App\Models\Notifications;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backend\Pages\DynamicComponentController;

class BackendComposer
{
    public function compose(View $view): void
    {
        try {
            // Only run this code on admin routes (URLs starting with 'admin/')
            if (!request()->is('admin/*')) {
                return; // Skip for non-admin requests
            }


            // Check database connection is available
            DB::connection()->getPdo();

            // Confirm the database name exists (meaning DB is connected)
            if (DB::connection()->getDatabaseName()) {

                // Share data with the view for admin pages
                $view->with([

                    // Count of unread notifications for the admin user
                    'unseenNotification' => app()->has('unseenNotificationCount')
                        ? app('unseenNotificationCount')
                        : tap(Notifications::where('is_read', 0)->count(), fn($value) => app()->instance('unseenNotificationCount', $value)),

                    // Get the latest 5 unread notifications, ordered by newest first
                    'notifications' => app()->has('unseenNotifications')
                        ? app('unseenNotifications')
                        : tap(Notifications::where('is_read', 0)->orderBy('created_at', 'desc')->take(5)->get(), fn($value) => app()->instance('unseenNotifications', $value)),

                    // General settings cached 
                    'general' => Cache::rememberForever('general_settings', fn() => General::first()),

                    // Backend font settings cached
                    'font_backend' => Cache::rememberForever(
                        'font_backend',
                        fn() => Font::where('is_backend', 1)->first()
                    ),

                    // Dynamic components (with child fields or database) for sidebar
                    'dynamicComponents' => Cache::remember('dynamic_sidebar_components', 300, fn() => DynamicComponentController::getManageableComponents()),


                ]);
            }
        } catch (\Exception $e) {
            // Silently ignore errors, e.g., if DB is down to avoid breaking views
        }
    }
}
