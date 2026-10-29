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
            $table->json('default_relationship_config')->nullable()->after('related_data');
            $table->json('default_advanced_relationship_config')->nullable()->after('default_relationship_config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            $table->dropColumn(['default_relationship_config', 'default_advanced_relationship_config']);
        });
    }
};

