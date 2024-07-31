<?php

use App\Jobs\StatusPipeline\StatusDelete;
use App\Status;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Status::doesntHave('profile')->get()->each(function ($status) {
            StatusDelete::dispatch($status);
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
