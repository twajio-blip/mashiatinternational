<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            if (!Schema::hasColumn('component_masters', 'is_connected')) {
                $table->boolean('is_connected')
                    ->default(false)
                    ->after('is_single');
            }

            if (!Schema::hasColumn('component_masters', 'data_source_component_id')) {
                $table->unsignedBigInteger('data_source_component_id')
                    ->nullable()
                    ->after('is_connected');

                $table->foreign('data_source_component_id')
                    ->references('id')
                    ->on('component_masters')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('component_masters', function (Blueprint $table) {
            if (Schema::hasColumn('component_masters', 'data_source_component_id')) {
                $table->dropForeign(['data_source_component_id']);
                $table->dropColumn('data_source_component_id');
            }

            if (Schema::hasColumn('component_masters', 'is_connected')) {
                $table->dropColumn('is_connected');
            }
        });
    }
};

