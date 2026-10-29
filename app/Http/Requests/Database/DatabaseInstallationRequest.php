<?php

namespace App\Http\Requests\Database;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class DatabaseInstallationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'DB_HOST' => 'required|string',
            'DB_USERNAME' => 'required|string',
            'DB_PASSWORD' => 'nullable|string',
            'DB_DATABASE' => 'required|string',
        ];
    }

    /**
     * Handle post-validation logic to ensure database credentials and database existence.
     */
    protected function passedValidation()
    {
        $dbHost = $this->input('DB_HOST');
        $dbUsername = $this->input('DB_USERNAME');
        $dbPassword = $this->input('DB_PASSWORD');
        $dbName = $this->input('DB_DATABASE');

        // Dynamically configure database connection
        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => null, // No database selected yet
                'username' => $dbUsername,
                'password' => $dbPassword,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        try {
            // Attempt to connect to the server
            DB::purge('dynamic'); // Clear cached connection
            DB::connection('dynamic')->getPdo();

            // Check if the database exists
            $databases = DB::connection('dynamic')->select('SHOW DATABASES');
            $databaseExists = collect($databases)->pluck('Database')->contains($dbName);

            if (!$databaseExists) {
                throw ValidationException::withMessages([
                    'DB_DATABASE' => 'The database "' . $dbName . '" does not exist. Please ensure the database is created before proceeding.',
                ]);
            }
        } catch (\PDOException $e) {
            // Check specific error codes and map to relevant fields
            $errorCode = $e->getCode();

            $messages = [];
            if ($errorCode == 2002) { // Host not found
                $messages['DB_HOST'] = 'Unable to connect to the database host "' . $dbHost . '". Please verify the host address.';
            } else if ($errorCode == 1045) { // Invalid username or password
                $messages['DB_USERNAME'] = 'The database username "' . $dbUsername . '" is incorrect. Please verify your credentials.';
                $messages['DB_PASSWORD'] = 'Ensure that the password provided is correct.';
            } else {
                $messages['DB_CONNECTION'] = 'A connection error occurred: ' . $e->getMessage() . '. Please review your database connection details.';
            }
         

            throw ValidationException::withMessages($messages);
        }
    }
}
