<?php

use App\Status;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Status::whereNotNull('reblog_of_id')
            ->whereNull('type')
            ->update([
                'type' => 'share',
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
