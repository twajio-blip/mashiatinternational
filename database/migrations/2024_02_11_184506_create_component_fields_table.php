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
        Schema::create('component_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('component_id');
            $table->string('name');
            $table->string('type');
            $table->text('value')->nullable();
            $table->string('group')->nullable();
            $table->integer('position')->nullable();
            $table->integer('page_id')->nullable();
            $table->timestamps();
            $table->foreign('component_id')->references('id')->on('component_masters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_fields');
    }
};