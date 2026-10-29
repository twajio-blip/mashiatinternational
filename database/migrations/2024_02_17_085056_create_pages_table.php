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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('permalink');
            $table->text('description')->nullable();
            $table->longText('page_text_content')->nullable();
            $table->string('status')->default(0);
            $table->boolean('is_breadcrumb')->default(0);
            $table->longText('image')->nullable(); 
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->longText('seo_image')->nullable();
            $table->text('seo_index')->nullable();
            $table->longText('header_component')->nullable();
            $table->string('header_component_position')->nullable();
            $table->longText('footer_component')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
