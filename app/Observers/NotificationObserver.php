<?php

namespace App\Observers;

use App\Notification;
use App\Services\NotificationService;

class NotificationObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the notification "created" event.
     */
    public function created(Notification $notification): void
    {
        NotificationService::set($notification->profile_id, $notification->id);
    }

    /**
     * Handle the notification "updated" event.
     */
    public function updated(Notification $notification): void
    {
        NotificationService::set($notification->profile_id, $notification->id);
    }

    /**
     * Handle the notification "deleted" event.
     */
    public function deleted(Notification $notification): void
    {
        NotificationService::del($notification->profile_id, $notification->id);
    }

    /**
     * Handle the notification "restored" event.
     */
    public function restored(Notification $notification): void
    {
        NotificationService::set($notification->profile_id, $notification->id);
    }

    /**
     * Handle the notification "force deleted" event.
     */
    public function forceDeleted(Notification $notification): void
    {
        NotificationService::del($notification->profile_id, $notification->id);
    }
}
