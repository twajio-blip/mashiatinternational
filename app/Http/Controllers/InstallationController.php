<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Database\DatabaseInstallationRequest;
use App\Models\Setting;
use App\Models\User;
use App\Services\CommonServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class InstallationController extends Controller
{
    public function installationFirstStep()
    {

        $data['curl_enabled']           = function_exists('curl_version');
        $data['db_file_write_perm']     = is_writable(base_path('.env'));
        $data['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
        return view('installation.installation_first_step', compact('data'));
    }

    public function installationSecondStep()
    {
        $data['curl_enabled']           = function_exists('curl_version');
        $data['db_file_write_perm']     = is_writable(base_path('.env'));
        $data['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
        return view('installation.installation_second_step', compact('data'));
    }
    public function installationThirdStep()
    {
        return view('installation.installation_third_step');
    }

    public function installationFourthStep($error = "")
    {
        return view('installation.installation_fourth_step');
    }

    public function installationFifthStep()
    {
        return view('installation.installation_fifth_step');
    }

    public function installationSixthStep()
    {
        return view('installation.installation_sixth_step');
    }

    public function purchase_code(Request $request)
    {
        return redirect()->route('step3');
    }

    public function system_settings(Request $request)
    {

        //sleep(5);
        $this->writeEnvironmentFile('APP_NAME', $request->name);

        $user = new User();
        $user->name      = $request->admin_name;
        $user->email     = $request->admin_email;
        $user->password  = Hash::make($request->admin_password);
        $user->email_verified_at = date('Y-m-d H:m:s');
        $user->save();

        $existingRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $existingRouteServiceProvier);


        //sleep(5);
        return view('installation.installation_seventh_step');
    }
    public function database_installation(DatabaseInstallationRequest $request)
    {

        try {
            if ($this->check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {
                $path = base_path('.env');
                if (file_exists($path)) {
                    foreach ($request->types as $type) {
                        $this->writeEnvironmentFile($type, $request[$type]);
                    }
                    return redirect()->route('step4');
                } else {
                    return redirect()->route('step3');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('step3')->with('error', 'Your information is invalid');
        }
    }

    public function import_sql()
    {

       $this->dropAllTables();
        $sql_path = base_path('main-cms.sql');
        DB::unprepared(file_get_contents($sql_path));
        return redirect()->route('step5');
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "")
    {

        if (@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        } else {
            return false;
        }
    }

    public function writeEnvironmentFile($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            file_put_contents($path, str_replace(
                $type . '="' . env($type) . '"',
                $type . '=' . $val,
                file_get_contents($path)
            ));
        }
    }
    function dropAllTables()
    {
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Get all table names
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . DB::getDatabaseName();

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                DB::statement("DROP TABLE `$tableName`");
            }

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return "All tables dropped successfully!";
        } catch (\Exception $e) {
            return "Error while dropping tables: " . $e->getMessage();
        }
    }
}
