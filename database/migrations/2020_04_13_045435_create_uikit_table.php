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
        Schema::create('uikit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('k')->unique()->index();
            $table->text('v')->nullable();
            $table->json('meta')->nullable();
            // default value for rollbacks
            $table->text('defv')->nullable();
            // delta history
            $table->text('dhis')->nullable();
            $table->unsignedInteger('edit_count')->default(0)->nullable();
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
        Schema::dropIfExists('uikit');
    }
};
