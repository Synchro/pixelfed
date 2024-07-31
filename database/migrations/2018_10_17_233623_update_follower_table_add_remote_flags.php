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
        Schema::table('followers', function (Blueprint $table) {
            $table->boolean('local_profile')->default(true)->index()->after('following_id');
            $table->boolean('local_following')->default(true)->index()->after('local_profile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('followers', function (Blueprint $table) {
            $table->dropColumn(['local_profile', 'local_following']);
        });
    }
};
