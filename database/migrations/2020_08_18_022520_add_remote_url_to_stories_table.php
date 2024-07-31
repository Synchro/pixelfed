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
        Schema::table('stories', function (Blueprint $table) {
            $table->string('remote_url')->nullable()->index()->unique()->after('path');
            $table->string('media_url')->nullable()->index()->unique()->after('remote_url');
            $table->boolean('is_archived')->default(false)->nullable()->index();
            $table->string('name')->nullable();
        });
        Schema::table('media', function (Blueprint $table) {
            $table->string('blurhash')->nullable();
            $table->json('srcset')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn(['remote_url', 'media_url', 'is_archived', 'name']);
        });
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['blurhash', 'srcset', 'width', 'height']);
        });
    }
};
