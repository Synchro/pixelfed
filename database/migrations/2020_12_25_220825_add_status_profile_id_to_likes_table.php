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
        Schema::table('likes', function (Blueprint $table) {
            $table->bigInteger('status_profile_id')->nullable()->unsigned()->index()->after('status_id');
            $table->boolean('is_comment')->nullable()->index()->after('status_profile_id');
            $table->dropColumn('flagged');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropColumn(['status_profile_id', 'is_comment']);
            $table->boolean('flagged')->default(false);
        });
    }
};
