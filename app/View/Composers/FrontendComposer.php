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

class FrontendComposer
{
    public function compose(View $view): void
    {
        try {
            // Skip if the current request is for admin or API routes
            if (request()->is('admin/*') || request()->is('api/*')) {
                return; // No need to inject view data for admin or API
            }

            // Check if the database is connected and accessible
            DB::connection()->getPdo();
            if (DB::connection()->getDatabaseName()) {

                // Share data with views using $view->with()
                $view->with([

                    // Placeholder for static header pages (customize with actual data if needed)
                    'headerPages' => [],

                    // Placeholder for static footer pages (customize with actual data if needed)
                    'footerPages' => [],

                    // General settings 
                    'general' => Cache::rememberForever('general_settings', fn() => General::first()),

                    // List of services 
                    'service' => Cache::rememberForever('services', fn() => Services::get()),

                    // Footer groups with nested details 
                    'footerGroups' => Cache::rememberForever(
                        'footer_groups',
                        fn() => FooterGroup::with('details')->get()
                    ),

                    // Up to 6 gallery images with category info 
                    'galleryImages' => Cache::rememberForever(
                        'gallery_images',
                        fn() => GalleryImage::with('category')->limit(6)->get()
                    ),

                    // Font settings for frontend 
                    'font_frontend' => Cache::rememberForever(
                        'font_frontend',
                        fn() => Font::where('is_frontend', 1)->first()
                    ),

                ]);
            }
        } catch (\Exception $e) {
            // Fail silently if any error occurs (e.g., DB not available)
        }
    }
}


                    // //  $headerPages = Widget::with('children')->whereNull('parent_id')->orderBy('position')->get();
                

                    // $headerPages = Widget::where('type', 'header')
                    //     ->whereHas('page', function ($q) {
                    //         $q->where('status', 1);
                    //     })
                    //     ->with(['page' => function ($q) {
                    //         $q->where('status', 1);
                    //     }])
                    //     ->orderBy('id')
                    //     ->get();

                    // $footerPages = Widget::where('type', 'footer')->orderBy('id')->whereHas('page', function ($q) {
                    //     $q->where('status', 1);
                    // })
                    //     ->with(['page' => function ($q) {
                    //         $q->where('status', 1);
                    //     }])->get();
