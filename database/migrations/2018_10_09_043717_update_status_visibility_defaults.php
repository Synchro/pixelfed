<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $type = config('database.default');
        switch ($type) {
            case 'mysql':
                DB::statement("ALTER TABLE statuses CHANGE COLUMN visibility visibility ENUM('public','unlisted','private','direct', 'draft') NOT NULL DEFAULT 'public'");
                break;

            case 'pgsql':
                break;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
    }
};
