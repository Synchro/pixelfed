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
        Schema::table('profiles', function (Blueprint $table) {
            $table->timestamp('delete_after')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('delete_after')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('delete_after');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('delete_after');
        });
    }
};
