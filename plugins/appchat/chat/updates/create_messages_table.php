<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\User;
use AppChat\Chat\Models\Emoji;
use AppChat\Chat\Models\Message;

/**
 * CreateMessagesTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_messages', function(Blueprint $table) {
            $table->id();
            $table->text('message')->nullable();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Chat::class);
            $table->foreignIdFor(Emoji::class)->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('appchat_chat_messages');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_messages');
    }
};
