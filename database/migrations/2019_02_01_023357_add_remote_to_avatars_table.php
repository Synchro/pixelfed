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
        Schema::table('avatars', function (Blueprint $table) {
            $table->string('remote_url')->nullable()->index()->after('thumb_path');
            $table->timestamp('last_fetched_at')->nullable()->after('change_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('avatars', function (Blueprint $table) {
            $table->dropColumn(['remote_url', 'last_fetched_at']);
        });
    }
};
