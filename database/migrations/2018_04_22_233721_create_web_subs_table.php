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
        Schema::create('web_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('follower_id')->unsigned()->index();
            $table->bigInteger('following_id')->unsigned()->index();
            $table->string('profile_url')->index();
            $table->timestamp('approved_at')->nullable();
            $table->unique(['follower_id', 'following_id', 'profile_url']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_subs');
    }
};
