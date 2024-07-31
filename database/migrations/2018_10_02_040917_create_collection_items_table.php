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
        Schema::create('collection_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('collection_id')->unsigned()->index();
            $table->unsignedInteger('order')->nullable();
            $table->string('object_type')->default('post')->index();
            $table->bigInteger('object_id')->unsigned()->index();
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
        Schema::dropIfExists('collection_items');
    }
};
