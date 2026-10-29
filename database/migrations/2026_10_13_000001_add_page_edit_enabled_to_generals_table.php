<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->boolean('page_edit_enabled')->default(false)->after('cookie_description');
        });
    }

    public function down(): void
    {
        Schema::table('generals', function (Blueprint $table) {
            $table->dropColumn('page_edit_enabled');
        });
    }
};
