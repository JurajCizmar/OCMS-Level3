<?php namespace AppChat\Chat\Models;

use Model;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\User;
use AppChat\Chat\Models\ChatUserPivot;

/**
 * Chat Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Chat extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_chats';


    public $hasMany = [
        'messages' => Message::class
    ];

    public $belongsToMany = [
        'users' => [ 
            User::class, 
            'table' => 'appchat_chat_chat_user_pivots',
            'pivotModel' => ChatUserPivot::class
        ]
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'nullable|string|max:255'
    ];
}
