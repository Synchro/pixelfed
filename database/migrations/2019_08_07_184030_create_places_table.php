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
        Schema::create('places', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->index();
            $table->string('name')->index();
            $table->string('country')->index();
            $table->json('aliases')->nullable();
            $table->decimal('lat', 9, 6)->nullable();
            $table->decimal('long', 9, 6)->nullable();
            $table->unique(['slug', 'country', 'lat', 'long']);
            $table->timestamps();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->bigInteger('place_id')->unsigned()->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('place_id');
        });
    }
};
