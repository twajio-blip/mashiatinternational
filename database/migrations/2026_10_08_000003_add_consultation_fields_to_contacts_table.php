<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('phone');
            $table->string('intake')->nullable()->after('destination');
            $table->string('service')->nullable()->after('intake');
            $table->text('message')->nullable()->after('service');
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['destination', 'intake', 'service', 'message']);
        });
    }
};
