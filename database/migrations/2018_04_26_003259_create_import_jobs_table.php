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
        Schema::create('import_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('profile_id')->unsigned();
            $table->string('service')->default('instagram');
            $table->string('uuid')->nullable();
            $table->string('storage_path')->nullable();
            $table->tinyInteger('stage')->unsigned()->default(0);
            $table->text('media_json')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_jobs');
    }
};
