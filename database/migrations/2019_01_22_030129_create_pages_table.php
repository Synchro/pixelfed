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
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('root')->nullable()->index();
            $table->string('slug')->nullable()->unique()->index();
            $table->string('title')->nullable();
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->longText('content')->nullable();
            $table->string('template')->default('layouts.app')->index();
            $table->boolean('active')->default(false)->index();
            $table->boolean('cached')->default(true)->index();
            $table->timestamp('active_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
