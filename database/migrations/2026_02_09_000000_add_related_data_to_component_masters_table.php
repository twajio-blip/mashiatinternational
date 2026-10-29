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
            $table->json('related_data')->nullable()->after('relational_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn('related_data');
        });
    }
};

