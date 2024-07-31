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
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('item_id');
            $table->index('item_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('notifications_item_id_index');
            $table->dropIndex('notifications_item_type_index');
        });
    }
};
