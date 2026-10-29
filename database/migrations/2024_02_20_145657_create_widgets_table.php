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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('name')->nullable();
            $table->string('type');
            $table->unsignedBigInteger('ref_id')->nullable(); // original `id` from client
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('position'); // for ordering
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
