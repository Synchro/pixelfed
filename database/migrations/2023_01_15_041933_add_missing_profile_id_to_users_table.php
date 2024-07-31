<?php

use App\Profile;
use App\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        User::whereNull('profile_id')
            ->chunk(20, function ($users) {
                foreach ($users as $user) {
                    $profile = Profile::whereUsername($user->username)->first();
                    if ($profile) {
                        $user->profile_id = $profile->id;
                        $user->save();
                    }
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
