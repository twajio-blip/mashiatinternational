<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('component_fields', function (Blueprint $table) {
            $table->unsignedTinyInteger('colspan')->default(6)->after('show_in_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_fields', function (Blueprint $table) {
            $table->dropColumn('colspan');
        });
    }
};
