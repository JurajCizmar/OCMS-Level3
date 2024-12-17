<?php namespace AppChat\Chat\Models;

use Model;
use AppChat\Chat\Models\Chat;
use AppUser\User\Models\User;
use AppChat\Chat\Models\Emoji;
use System\Models\File;

/**
 * Message Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Message extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_messages';

    protected $fillable = ['message', 'user_id', 'chat_id', 'parent_id'];

    /**
     * @var array table relationships
     */
    public $belongsTo = [
        'chat' => Chat::class,
        'user' => User::class,
        'emoji' => Emoji::class,
        'parentMessage' => [
            Message::class, 
            'key' => 'parent_id'
        ]
    ];

    public $hasMany = [
        'replies' => [
            Message::class, 
            'key' => 'parent_id'
        ]
    ];

    public $attachOne = [
        'attachment' => File::class
    ];


    /**
     * @var array rules for validation
     */
    public $rules = [
        'user_id' => 'required',
        'chat_id' => 'required',
        'message' => 'string|max:1000'
    ];
}
