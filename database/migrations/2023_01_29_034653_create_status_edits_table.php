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
        Schema::create('status_edits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status_id')->unsigned()->index();
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->text('caption')->nullable();
            $table->text('spoiler_text')->nullable();
            $table->json('ordered_media_attachment_ids')->nullable();
            $table->json('media_descriptions')->nullable();
            $table->json('poll_options')->nullable();
            $table->boolean('is_nsfw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_edits');
    }
};
