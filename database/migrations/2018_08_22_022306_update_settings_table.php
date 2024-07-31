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
        Schema::table('user_settings', function (Blueprint $table) {
            $table->boolean('show_profile_followers')->default(true);
            $table->boolean('show_profile_follower_count')->default(true);
            $table->boolean('show_profile_following')->default(true);
            $table->boolean('show_profile_following_count')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn(['show_profile_followers', 'show_profile_follower_count', 'show_profile_following', 'show_profile_following_count']);
        });
    }
};
