<?php

namespace App\Observers;

use App\Jobs\HomeFeedPipeline\FeedFollowPipeline;
use App\Jobs\HomeFeedPipeline\FeedUnfollowPipeline;
use App\Services\UserFilterService;
use App\UserFilter;

class UserFilterObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the user filter "created" event.
     */
    public function created(UserFilter $userFilter): void
    {
        $this->filterCreate($userFilter);
    }

    /**
     * Handle the user filter "updated" event.
     */
    public function updated(UserFilter $userFilter): void
    {
        $this->filterCreate($userFilter);
    }

    /**
     * Handle the user filter "deleted" event.
     */
    public function deleted(UserFilter $userFilter): void
    {
        $this->filterDelete($userFilter);
    }

    /**
     * Handle the user filter "restored" event.
     */
    public function restored(UserFilter $userFilter): void
    {
        $this->filterCreate($userFilter);
    }

    /**
     * Handle the user filter "force deleted" event.
     */
    public function forceDeleted(UserFilter $userFilter): void
    {
        $this->filterDelete($userFilter);
    }

    protected function filterCreate(UserFilter $userFilter)
    {
        if ($userFilter->filterable_type !== \App\Profile::class) {
            return;
        }

        switch ($userFilter->filter_type) {
            case 'mute':
                UserFilterService::mute($userFilter->user_id, $userFilter->filterable_id);
                FeedUnfollowPipeline::dispatch($userFilter->user_id, $userFilter->filterable_id)->onQueue('feed');
                break;

            case 'block':
                UserFilterService::block($userFilter->user_id, $userFilter->filterable_id);
                FeedUnfollowPipeline::dispatch($userFilter->user_id, $userFilter->filterable_id)->onQueue('feed');
                break;
        }
    }

    protected function filterDelete(UserFilter $userFilter)
    {
        if ($userFilter->filterable_type !== \App\Profile::class) {
            return;
        }

        switch ($userFilter->filter_type) {
            case 'mute':
                UserFilterService::unmute($userFilter->user_id, $userFilter->filterable_id);
                FeedFollowPipeline::dispatch($userFilter->user_id, $userFilter->filterable_id)->onQueue('feed');
                break;

            case 'block':
                UserFilterService::unblock($userFilter->user_id, $userFilter->filterable_id);
                FeedFollowPipeline::dispatch($userFilter->user_id, $userFilter->filterable_id)->onQueue('feed');
                break;
        }
    }
}
