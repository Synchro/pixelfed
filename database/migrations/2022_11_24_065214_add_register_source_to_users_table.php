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
        Schema::table('users', function (Blueprint $table) {
            $table->string('register_source')->default('web')->nullable()->index();
            $table->string('app_register_token')->nullable();
            $table->string('app_register_ip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('register_source');
            $table->dropColumn('app_register_token');
            $table->dropColumn('app_register_ip');
        });
    }
};
