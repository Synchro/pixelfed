<?php

use App\UserSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        UserSetting::whereNotNull('compose_settings')
            ->chunk(50, function ($settings) {
                foreach ($settings as $userSetting) {
                    if (is_array($userSetting->compose_settings)) {
                        continue;
                    }
                    $userSetting->compose_settings = json_decode($userSetting->compose_settings);
                    $userSetting->save();
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
