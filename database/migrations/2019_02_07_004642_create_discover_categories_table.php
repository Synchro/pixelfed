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
        Schema::create('discover_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->unique()->index();
            $table->boolean('active')->default(false)->index();
            $table->tinyInteger('order')->unsigned()->default(5);
            $table->bigInteger('media_id')->unsigned()->unique()->nullable();
            $table->boolean('no_nsfw')->default(true);
            $table->boolean('local_only')->default(true);
            $table->boolean('public_only')->default(true);
            $table->boolean('photos_only')->default(true);
            $table->timestamp('active_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discover_categories');
    }
};
