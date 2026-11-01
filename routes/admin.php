<?php

use App\Http\Controllers\Backend\Blog\BlogCategoryController;
use App\Http\Controllers\Backend\Blog\BlogPostController;
use App\Http\Controllers\Backend\Career\CareerCategoryController;
use App\Http\Controllers\Backend\Career\CareerController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\Component\ComponentController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\Faq\FaqController;
use App\Http\Controllers\Backend\Font\FontController;
use App\Http\Controllers\Backend\Gallery\GalleryCategoryController;
use App\Http\Controllers\Backend\Gallery\GalleryImageController;
use App\Http\Controllers\Backend\NotificationController;
use App\Http\Controllers\Backend\Pages\PagesController;
use App\Http\Controllers\Backend\Profile\ProfileController;
use App\Http\Controllers\Backend\Services\ServiceController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\Slider\SliderController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\Theme\ThemeController;
use App\Http\Controllers\Backend\Widget\WidgetController;
use App\Http\Controllers\Backend\Work\WorkCategoryController;
use App\Http\Controllers\Backend\Work\WorkPostController;
use Illuminate\Support\Facades\Route;



Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('component', ComponentController::class);
    Route::get('component/{id}/export-sql', [ComponentController::class, 'exportSql'])->name('component.export-sql');
    Route::get('component/{id}/export-sql-view', [ComponentController::class, 'exportSqlView'])->name('component.export-sql-view');
    Route::post('component/reorder', [ComponentController::class, 'reorder'])->name('component.reorder');
    Route::post('delete-field', [ComponentController::class, 'fieldDelete'])->name('delete-field');
    Route::resource('pages', PagesController::class);

    Route::post('add-ui', [PagesController::class, 'addui'])->name('add-ui');

    // Dynamic component management (field-wise table, insert, edit, delete)
    Route::prefix('dynamic-component')->name('dynamic-component.')->group(function () {
        Route::get('{slug}', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'index'])->name('index');
        Route::get('{slug}/create', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'create'])->name('create');
        Route::post('{slug}', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'store'])->name('store');
        Route::get('{slug}/{id}/edit', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'edit'])->name('edit');
        Route::put('{slug}/{id}', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'update'])->name('update');
        Route::delete('{slug}/{id}', [\App\Http\Controllers\Backend\Pages\DynamicComponentController::class, 'destroy'])->name('destroy');
    });
    Route::resource('company', CompanyController::class);
    Route::resource('widget', WidgetController::class);
    Route::resource('theme-option', ThemeController::class);
    Route::post('theme-option-contact', [ThemeController::class, 'contact'])->name('theme-option.contact');
    Route::post('theme-option-logo', [ThemeController::class, 'logo'])->name('theme-option.logo');
    Route::post('theme-option-social', [ThemeController::class, 'social'])->name('theme-option.social');
    Route::post('theme-option-footer', [ThemeController::class, 'footer'])->name('theme-option.footer');

    Route::resource('slider', SliderController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('faq', FaqController::class);

    // Gallery Route
    Route::prefix('gallery')->name('gallery.')->group(function () {
        Route::resource('categories', GalleryCategoryController::class);
        Route::resource('images', GalleryImageController::class);
    });

    // Career Route
    Route::prefix('career')->name('career.')->group(function () {
        Route::resource('categories', CareerCategoryController::class);
        Route::resource('career', CareerController::class);
    });
    // Profile Route

    Route::resource('profile', ProfileController::class);


    //Blog Route
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::resource('categories', BlogCategoryController::class);
        Route::resource('posts', BlogPostController::class);
    });

    //Work Route
    Route::prefix('work')->name('work.')->group(function () {
        Route::resource('categories', WorkCategoryController::class);
        Route::resource('posts', WorkPostController::class);
    });

    //Contact 
    Route::resource('contact', ContactController::class);
    Route::post('contact/updateAll', [ContactController::class, 'updateAll'])->name('contact.updateAll');

    // Notification
    Route::resource('notification', NotificationController::class);
    // Notification
    Route::resource('font', FontController::class);

    // Subscriber
    Route::resource('subscriber', SubscriberController::class);

    //Load Style Component
    Route::post('load/style/component', [PagesController::class, 'loadComponent'])->name('load.style.component');
    Route::post('load/style/store', [PagesController::class, 'loadComponentStore'])->name('load.style.component.store');


    //SMTP settings
    Route::view('/smtp-setup', 'backend.settings.smtp')->name('smtp_setup');
    Route::post('/write-on-env-file', [SettingsController::class, 'write_on_env_file'])->name('write_env');
    Route::get('/clear-cache', [SettingsController::class, 'clearCache'])->name('cache.clear');


    // Show the header and footer settings (GET)
    Route::get('header-footer-settings', [SettingsController::class, 'headerFooterSettings'])
        ->name('header.footer.settings');

    // Store/update the header and footer settings (POST)
    Route::post('header-footer-settings', [SettingsController::class, 'storeHeaderFooterSettings'])
        ->name('header.footer.setting.store');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
