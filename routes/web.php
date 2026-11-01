<?php

use App\Models\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Backend\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['visitor'])->group(function () {

    if (Schema::hasColumn('pages', 'permalink')) {
        $page = Page::pluck('permalink');
    } else {

        $page = [];
    }
    foreach ($page as $key => $url) {
        Route::get($url, [PageController::class, 'index']);

    }
    Route::get('data-view/{id}/current_page_id/{current_page_id?}', [PageController::class, 'dataView'])->name('data-view');

    if (count($page) == 0) {
        Route::get('/', [PageController::class, 'defaultPage']);
    }
    Route::get('service-view/{id}', [PageController::class, 'serviceView'])->name('service-view');
    Route::get('blog/view/{id}/current_page_id/{current_page_id?}', [PageController::class, 'blogView'])->name('blog.view');
    Route::get('list/view/{id}/current_page_id/{current_page_id?}', [PageController::class, 'listView'])->name('list.view');
    Route::get('news/view/{id}/current_page_id/{current_page_id?}', [PageController::class, 'blogView'])->name('article.view');
    Route::get('job/view/{id}/current_page_id/{current_page_id?}', [PageController::class, 'jobView'])->name('job.view');
    Route::get('gallery/view/{id}', [PageController::class, 'galleryView'])->name('gallery.view');

    Route::post('contact/store', [PageController::class, 'contactStore'])->name('contact.store.frontend');
    Route::post('subscriber/store', [PageController::class, 'subscriberStore'])->name('subscriber.store.frontend');
    Route::post('/switch-language', [LanguageController::class, 'switch_language'])->name('switch_language');
    Route::get('view/page_id/{page_id?}/group/{group?}/component/{component_id?}/current_page_id/{current_page_id?}/view_page_name/{view_page_name?}', [PageController::class, 'pageDetails'])->name('page.details.view');


});


Route::get('admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Clear all optimization caches (config, route, view, cache) – auth required
Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
    return response()->json([
        'message' => 'Optimization caches cleared.',
        'output' => trim(Artisan::output()),
    ]);
})->name('optimize.clear');






require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
