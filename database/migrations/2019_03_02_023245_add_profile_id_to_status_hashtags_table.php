<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('status_hashtags', function (Blueprint $table) {
            $table->bigInteger('profile_id')->unsigned()->nullable()->index()->after('hashtag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('status_hashtags', function (Blueprint $table) {
            $table->dropColumn('profile_id');
        });
    }
};
