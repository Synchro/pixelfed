<?php

use App\Bookmark;
use App\Services\FollowerService;
use App\Status;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Bookmark::chunk(200, function ($bookmarks) {
            foreach ($bookmarks as $bookmark) {
                $status = Status::find($bookmark->status_id);
                if (! $status) {
                    $bookmark->delete();

                    continue;
                }

                if (! in_array($status->visibility, ['public', 'unlisted', 'private'])) {
                    $bookmark->delete();

                    continue;
                }

                if (! in_array($status->visibility, ['public', 'unlisted'])) {
                    if ($bookmark->profile_id == $status->profile_id) {
                        continue;
                    } else {
                        if (! FollowerService::follows($bookmark->profile_id, $status->profile_id)) {
                            $bookmark->delete();
                        }
                    }
                }
            }
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
