<?php

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/


Schedule::command('media:optimize')->hourlyAt(40)->onOneServer();
Schedule::command('media:gc')->hourlyAt(5)->onOneServer();
Schedule::command('horizon:snapshot')->everyFiveMinutes()->onOneServer();
Schedule::command('story:gc')->everyFiveMinutes()->onOneServer();
Schedule::command('gc:failedjobs')->dailyAt(3)->onOneServer();
Schedule::command('gc:passwordreset')->dailyAt('09:41')->onOneServer();
Schedule::command('gc:sessions')->twiceDaily(13, 23)->onOneServer();
Schedule::command('app:weekly-instance-scan')->weeklyOn(2, '4:20')->onOneServer();

if ((bool) config_cache('pixelfed.cloud_storage') && (bool) config_cache('media.delete_local_after_cloud')) {
    Schedule::command('media:s3gc')->hourlyAt(15);
}

if (config('import.instagram.enabled')) {
    Schedule::command('app:transform-imports')->everyTenMinutes()->onOneServer();
    Schedule::command('app:import-upload-garbage-collection')->hourlyAt(51)->onOneServer();
    Schedule::command('app:import-remove-deleted-accounts')->hourlyAt(37)->onOneServer();
    Schedule::command('app:import-upload-clean-storage')->twiceDailyAt(1, 13, 32)->onOneServer();

    if (config('import.instagram.storage.cloud.enabled') && (bool) config_cache('pixelfed.cloud_storage')) {
        Schedule::command('app:import-upload-media-to-cloud-storage')->hourlyAt(39)->onOneServer();
    }
}

Schedule::command('app:notification-epoch-update')->weeklyOn(1, '2:21')->onOneServer();
Schedule::command('app:hashtag-cached-count-update')->hourlyAt(25)->onOneServer();
Schedule::command('app:account-post-count-stat-update')->everySixHours(25)->onOneServer();
Schedule::command('app:instance-update-total-local-posts')->twiceDailyAt(1, 13, 45)->onOneServer();
