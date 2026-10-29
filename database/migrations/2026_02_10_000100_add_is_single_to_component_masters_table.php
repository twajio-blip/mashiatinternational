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
        Schema::table('component_masters', function (Blueprint $table) {
            // Place after related_data to avoid relying on is_multiple existing in all environments
            $table->boolean('is_single')->default(false)->after('related_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn('is_single');
        });
    }
};

