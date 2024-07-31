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
        Schema::create('group_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->unsigned()->nullable()->index();
            $table->bigInteger('profile_id')->unsigned()->nullable()->index();
            $table->string('name')->nullable();
            $table->string('type')->index();
            $table->json('tags')->nullable();
            $table->json('location')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('open')->default(false)->index();
            $table->boolean('comments_open')->default(false);
            $table->boolean('show_guest_list')->default(false);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_events');
    }
};
