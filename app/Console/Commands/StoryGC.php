<?php

namespace App\Console\Commands;

use App\Jobs\StoryPipeline\StoryExpire;
use App\Jobs\StoryPipeline\StoryRotateMedia;
use App\Services\StoryService;
use App\Story;
use Illuminate\Console\Command;

class StoryGC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'story:gc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear expired Stories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->archiveExpiredStories();
        $this->rotateMedia();
    }

    protected function archiveExpiredStories()
    {
        $stories = Story::whereActive(true)
            ->where('expires_at', '<', now())
            ->get();

        foreach ($stories as $story) {
            StoryExpire::dispatch($story)->onQueue('story');
        }
    }

    protected function rotateMedia()
    {
        $queue = StoryService::rotateQueue();

        if (! $queue || count($queue) == 0) {
            return;
        }

        collect($queue)
            ->each(function ($id) {
                $story = StoryService::getById($id);
                if (! $story) {
                    StoryService::removeRotateQueue($id);

                    return;
                }
                if ($story->created_at->gt(now()->subMinutes(20))) {
                    return;
                }
                StoryRotateMedia::dispatch($story)->onQueue('story');
                StoryService::removeRotateQueue($id);

            });
    }
}
