<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Replaces schema_group_names + is_multiple with schema_group_settings (per-group name + is_multiple).
     * Adds schema_instance for per-group multiple instances.
     */
    public function up(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->json('schema_group_settings')->nullable()->after('position');
        });

        // Migrate schema_group_names + is_multiple to schema_group_settings
        $masters = DB::table('component_masters')->get();
        foreach ($masters as $master) {
            $names = $master->schema_group_names ? json_decode($master->schema_group_names, true) : [];
            $isMultiple = (bool) ($master->is_multiple ?? false);
            $settings = [];
            if (is_array($names)) {
                foreach ($names as $gid => $name) {
                    $settings[$gid] = [
                        'name' => $name ?? 'Group ' . $gid,
                        'is_multiple' => $isMultiple,
                    ];
                }
            }
            if (!empty($settings)) {
                DB::table('component_masters')->where('id', $master->id)->update([
                    'schema_group_settings' => json_encode($settings),
                ]);
            }
        }

        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn(['schema_group_names', 'is_multiple']);
        });

        Schema::table('component_fields', function (Blueprint $table) {
            $table->unsignedTinyInteger('schema_instance')->default(1)->after('schema_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_fields', function (Blueprint $table) {
            $table->dropColumn('schema_instance');
        });

        Schema::table('component_masters', function (Blueprint $table) {
            $table->json('schema_group_names')->nullable();
            $table->boolean('is_multiple')->default(false);
        });

        // Migrate back: extract names and is_multiple from schema_group_settings
        $masters = DB::table('component_masters')->get();
        foreach ($masters as $master) {
            $settings = $master->schema_group_settings ? json_decode($master->schema_group_settings, true) : [];
            $names = [];
            $anyMultiple = false;
            if (is_array($settings)) {
                foreach ($settings as $gid => $s) {
                    $names[$gid] = $s['name'] ?? 'Group ' . $gid;
                    if (!empty($s['is_multiple'])) {
                        $anyMultiple = true;
                    }
                }
            }
            DB::table('component_masters')->where('id', $master->id)->update([
                'schema_group_names' => !empty($names) ? json_encode($names) : null,
                'is_multiple' => $anyMultiple,
            ]);
        }

        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn('schema_group_settings');
        });
    }
};
