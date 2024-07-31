<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('avatars', function ($table) {
            $table->softDeletes();
        });

        Schema::table('likes', function ($table) {
            $table->softDeletes();
        });

        Schema::table('media', function ($table) {
            $table->softDeletes();
        });

        Schema::table('mentions', function ($table) {
            $table->softDeletes();
        });

        Schema::table('notifications', function ($table) {
            $table->softDeletes();
        });

        Schema::table('profiles', function ($table) {
            $table->softDeletes();
        });

        Schema::table('statuses', function ($table) {
            $table->softDeletes();
        });

        Schema::table('users', function ($table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
