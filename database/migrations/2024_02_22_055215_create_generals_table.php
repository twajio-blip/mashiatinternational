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
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('website_name')->nullable();
            $table->longText('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->text('social')->nullable();
            $table->longText('fav_icon')->nullable();
            $table->longText('header')->nullable();
            $table->longText('footer')->nullable();
            $table->longText('header_component')->nullable();
            $table->longText('header_component_position')->nullable();
            $table->longText('footer_component')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('cookie_title')->nullable();
            $table->longText('cookie_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    {
        Schema::dropIfExists('generals');
    }
};
