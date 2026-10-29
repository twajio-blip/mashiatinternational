<?php

namespace App\Providers;

use Livewire\Blaze\Blaze;
use App\View\Composers\BackendComposer;
use App\View\Composers\FrontendComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // $this->configureBlaze();
        View::composer('*', FrontendComposer::class);
        View::composer('*', BackendComposer::class);
    }

    /**
     * Configure Livewire Blaze for optimized Blade component rendering.
     * @see https://github.com/livewire/blaze
     */
    protected function configureBlaze(): void
    {
        // 1) Enable Blaze function-compiler for MOST components
        //    (fast, safe, no folding / memoization).
        Blaze::optimize()
            ->in(resource_path('views/components/frontend'), fold: false)

            // 2) Exclude components that rely on global view-composer
            //    data like $general / $pageinfo or request() for routing,
            //    so they keep using normal Blade.
            ->in(resource_path('views/components/frontend/header'), compile: false)
            ->in(resource_path('views/components/frontend/footer'), compile: false)
            ->in(resource_path('views/components/layouts'), compile: false)

            // 3) Use aggressive folding ONLY on the simple, stateless
            //    backend button component.
            ->in(resource_path('views/components/backend/button'), fold: true);
    }
}
