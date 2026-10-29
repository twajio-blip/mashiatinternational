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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('type'); // Type of notification (e.g., 'subscribe', 'contact')
            $table->string('title'); // Notification title
            $table->text('message')->nullable(); // Notification message
            $table->unsignedBigInteger('type_id')->nullable(); 
            $table->string('redirect_url')->nullable(); 
            $table->boolean('is_read')->default(0); // Whether the notification has been read
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
