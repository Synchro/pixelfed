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
        Schema::create('media_tags', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status_id')->unsigned()->index()->nullable();
            $table->bigInteger('media_id')->unsigned()->index();
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->string('tagged_username')->nullable();
            $table->boolean('is_public')->default(true)->index();
            $table->json('metadata')->nullable();
            $table->unique(['media_id', 'profile_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_tags');
    }
};
