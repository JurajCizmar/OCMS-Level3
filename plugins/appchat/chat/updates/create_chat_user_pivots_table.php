<?php namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateChatUserPivotsTable Migration
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
        Schema::create('appchat_chat_chat_user_pivots', function(Blueprint $table) {
            // $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('chat_id')->unsigned();
            $table->primary(['user_id', 'chat_id']);
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_chat_user_pivots');
    }
};
