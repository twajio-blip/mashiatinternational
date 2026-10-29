<?php

namespace App\Http\Controllers\Backend\Theme;

use App\Models\General;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FooterGroup;
use App\Services\Theme\ThemeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class ThemeController extends Controller
{
    public function index()
    {
        $general = General::first();
        $footerGroups = FooterGroup::with('details')->get();
        return view('backend.pages.theme.index', compact('general','footerGroups'));
    }
    public function contact()
    {
        $siteKey = request()->sitekey;
        $secretKey = request()->secretkey;
        $this->updateEnvVariables($siteKey, $secretKey);
        ThemeService::CreateGeneral(filterRequest(['sitekey', 'secretkey']));
        Cache::forget('general_settings');
        return redirect()->back()->with(['success' => "Setting change successfully"]);
    }
    public function logo()
    {
        ThemeService::CreateLogo(filterRequest());
        Cache::forget('general_settings');
        return redirect()->back()->with(['success' => "Setting change successfully"]);
    }
    public function social()
    {
        ThemeService::CreateSocial(filterRequest());
        Cache::forget('general_settings');
        return redirect()->back()->with(['success' => "Setting change successfully"]);
    }
    public function footer()
    {
        ThemeService::CreateFooterLink(filterRequest());
        Cache::forget('footer_groups');
        return redirect()->back()->with(['success' => "Footer links saved successfully"]);
    }
    protected function updateEnvFile(array $data)
{
    $envFile = base_path('.env');

    if (!File::exists($envFile)) {
        return false; // .env file does not exist
    }

    $envContent = File::get($envFile);

    foreach ($data as $key => $value) {
        // Prepare the pattern to find the key and its current value
        $pattern = "/^{$key}=.*/m";
        $replacement = "{$key}=\"{$value}\"";

        if (preg_match($pattern, $envContent)) {
            // If the key exists, replace its value
            $envContent = preg_replace($pattern, $replacement, $envContent);
        } else {
            // If the key does not exist, add it at the end of the file
            $envContent .= PHP_EOL . $replacement;
        }
    }

    // Save the updated content back to the .env file
    File::put($envFile, $envContent);

    return true;
}
/**
    * Update specific environment variables in .env file.
    */
    public function updateEnvVariables($siteKey,$secretKey)
    {
        $data = [
            'NOCAPTCHA_SITEKEY' => $siteKey,
            'NOCAPTCHA_SECRET'=> $secretKey,
        ];

        $this->updateEnvFile($data);

        return response()->json(['status' => 'Environment variables updated successfully']);
    }
}