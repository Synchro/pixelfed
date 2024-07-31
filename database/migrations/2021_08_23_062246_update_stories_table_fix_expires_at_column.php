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
            $indexes = Schema::getIndexes('stories');
            $indexesFound = collect($indexes)->map(function ($i) {
                return $i['name'];
            })->toArray();
            if (in_array('stories_expires_at_index', $indexesFound)) {
                $table->dropIndex('stories_expires_at_index');
            }
            $table->timestamp('expires_at')->default(null)->index()->nullable()->change();
            $table->boolean('can_reply')->default(true);
            $table->boolean('can_react')->default(true);
            $table->string('object_id')->nullable()->unique();
            $table->string('object_uri')->nullable()->unique();
            $table->string('bearcap_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $indexes = Schema::getIndexes('stories');
            $indexesFound = collect($indexes)->map(function ($i) {
                return $i['name'];
            })->toArray();
            if (in_array('stories_expires_at_index', $indexesFound)) {
                $table->dropIndex('stories_expires_at_index');
            }
            $table->timestamp('expires_at')->default(null)->index()->nullable()->change();
            $table->dropColumn('can_reply');
            $table->dropColumn('can_react');
            $table->dropColumn('object_id');
            $table->dropColumn('object_uri');
            $table->dropColumn('bearcap_token');
        });
    }
};
