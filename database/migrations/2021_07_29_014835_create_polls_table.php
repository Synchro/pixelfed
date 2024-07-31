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
        Schema::create('polls', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->bigInteger('story_id')->unsigned()->nullable()->index();
            $table->bigInteger('status_id')->unsigned()->nullable()->index();
            $table->bigInteger('group_id')->unsigned()->nullable()->index();
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->json('poll_options')->nullable();
            $table->json('cached_tallies')->nullable();
            $table->boolean('multiple')->default(false);
            $table->boolean('hide_totals')->default(false);
            $table->unsignedInteger('votes_count')->default(0);
            $table->timestamp('last_fetched_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
