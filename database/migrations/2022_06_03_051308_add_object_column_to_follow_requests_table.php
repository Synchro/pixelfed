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
        Schema::table('follow_requests', function (Blueprint $table) {
            $table->json('activity')->nullable()->after('following_id');
            $table->timestamp('handled_at')->nullable()->after('is_local');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follow_requests', function (Blueprint $table) {
            $table->dropColumn('activity');
            $table->dropColumn('handled_at');
        });
    }
};
