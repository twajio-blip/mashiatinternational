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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url');  // Page URL
            $table->text('browser');  // Browser info
            $table->string('ip_address');  // Visitor IP address
            $table->string('platform')->nullable();  // Operating system
            $table->string('device')->nullable();  // Device type (PC, Tablet, Mobile)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
