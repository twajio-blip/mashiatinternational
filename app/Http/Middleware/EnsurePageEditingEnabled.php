<?php

namespace App\Http\Middleware;

use App\Models\General;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsurePageEditingEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        $general = Cache::rememberForever('general_settings', fn() => General::first());

        if (! (bool) ($general?->page_edit_enabled ?? false)) {
            abort(403, 'Page editing is disabled.');
        }

        return $next($request);
    }
}
