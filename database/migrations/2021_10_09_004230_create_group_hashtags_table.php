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
        Schema::create('group_hashtags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique()->index();
            $table->string('formatted')->nullable();
            $table->boolean('recommended')->default(false);
            $table->boolean('sensitive')->default(false);
            $table->boolean('banned')->default(false);
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
        Schema::dropIfExists('group_hashtags');
    }
};
