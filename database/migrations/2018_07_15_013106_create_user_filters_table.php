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
        Schema::create('user_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('filterable_id')->unsigned();
            $table->string('filterable_type');
            $table->string('filter_type')->default('block')->index();
            $table->unique([
                'user_id',
                'filterable_id',
                'filterable_type',
                'filter_type',
            ], 'filter_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_filters');
    }
};
