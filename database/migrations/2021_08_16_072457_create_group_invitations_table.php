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
        Schema::create('group_invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('group_id')->unsigned()->index();
            $table->bigInteger('from_profile_id')->unsigned()->index();
            $table->bigInteger('to_profile_id')->unsigned()->index();
            $table->string('role')->nullable();
            $table->boolean('to_local')->default(true)->index();
            $table->boolean('from_local')->default(true)->index();
            $table->unique(['group_id', 'to_profile_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_invitations');
    }
};
