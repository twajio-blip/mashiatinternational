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
        Schema::create('component_masters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('set_from')->nullable();
            $table->string('database')->nullable();
            $table->string('relational_table')->nullable();
            $table->string('limit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_masters');
    }
};