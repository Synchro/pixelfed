<?php

use App\DirectMessage;
use App\Models\Conversation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('conversations');

        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('to_id')->unsigned()->index();
            $table->bigInteger('from_id')->unsigned()->index();
            $table->bigInteger('dm_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->string('type')->nullable();
            $table->boolean('is_hidden')->default(false)->index();
            $table->boolean('has_seen')->default(false)->index();
            $table->json('metadata')->nullable();
            $table->unique(['to_id', 'from_id']);
            $table->timestamps();
        });

        sleep(10);

        if (DirectMessage::count()) {

            foreach (DirectMessage::lazy() as $msg) {
                Conversation::updateOrInsert([
                    'to_id' => $msg->to_id,
                    'from_id' => $msg->from_id,
                ],
                    [
                        'dm_id' => $msg->id,
                        'status_id' => $msg->status_id,
                        'type' => $msg->type,
                        'created_at' => $msg->created_at,
                        'updated_at' => $msg->updated_at,
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
