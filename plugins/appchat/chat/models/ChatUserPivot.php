<?php namespace AppChat\Chat\Models;

use Model;
use October\Rain\Database\Pivot;
use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\User;

/**
 * ChatUserPivot Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class ChatUserPivot extends Pivot
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_chat_user_pivots';

    protected $fillable = ['user_id', 'chat_id'];

    public $hasMany = [
        'chats' => Chat::class,
        'users' => User::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
