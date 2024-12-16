<?php namespace AppChat\Chat\Models;

use Model;
use AppChat\Chat\Models\Message;

/**
 * Emoji Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Emoji extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appchat_chat_emoji';

    public $hasMany = [
        'messages' => Message::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'name' => 'required|string|max:50|unique:appchat_chat_emoji'
    ];
}
