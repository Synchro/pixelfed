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
        Schema::create('status_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('status_id')->unsigned()->nullable()->index();
            $table->bigInteger('status_profile_id')->unsigned()->nullable()->index();
            $table->bigInteger('profile_id')->unsigned()->nullable()->index();
            $table->unique(['status_id', 'profile_id']);
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
        Schema::dropIfExists('status_views');
    }
};
