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
        Schema::table('page_component_statuses', function (Blueprint $table) {
            $table->string('ui_mode')->default('default')->after('status');
            $table->json('relationship_config')->nullable()->after('ui_mode');
            $table->json('advanced_relationship_config')->nullable()->after('relationship_config');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_component_statuses', function (Blueprint $table) {
            $table->dropColumn(['ui_mode', 'relationship_config', 'advanced_relationship_config']);
        });
    }
};

