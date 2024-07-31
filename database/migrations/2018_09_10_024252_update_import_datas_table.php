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
        Schema::table('import_datas', function (Blueprint $table) {
            $table->bigInteger('job_id')->unsigned()->nullable()->after('profile_id');
            $table->string('original_name')->nullable()->after('stage');
            $table->boolean('import_accepted')->default(false)->nullable()->after('original_name');
            $table->unique(['job_id', 'original_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
