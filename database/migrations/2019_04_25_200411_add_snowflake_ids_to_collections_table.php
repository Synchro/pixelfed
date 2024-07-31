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
        Schema::table('collections', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->bigInteger('id')->unsigned()->primary()->change();
        });

        Schema::table('collection_items', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->bigInteger('id')->unsigned()->primary()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            //
        });
    }
};
