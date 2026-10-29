<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class LogVisitor
{

    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        $url = $request->fullUrl();
        $browser = $agent->browser();              // Chrome, Safari, Firefox, etc.
        $platform = $agent->platform();            // Windows, iOS, Android, etc.
        $ip = $request->ip();

        // Determine device type
        $device = 'PC';
        if ($agent->isTablet()) {
            $device = 'Tablet';
        } elseif ($agent->isMobile()) {
            $device = 'Mobile';
        }

        // Log visitor data
        DB::table('visitor_logs')->insert([
            'url' => $url,
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
            'ip_address' => $ip,
            'created_at' => now(),
        ]);

        return $next($request);
    }
}
