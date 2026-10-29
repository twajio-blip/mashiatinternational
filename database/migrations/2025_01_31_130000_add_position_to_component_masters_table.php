<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->unsignedInteger('position')->default(0)->after('limit');
        });
        // Set initial position from id for existing records
        DB::table('component_masters')->orderBy('id')->get()->each(function ($row, $index) {
            DB::table('component_masters')->where('id', $row->id)->update(['position' => $index + 1]);
        });
    }

    public function down(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
