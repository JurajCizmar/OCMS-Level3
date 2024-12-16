<?php namespace AppChat\Chat\Classes\Services;

use AppChat\Chat\Models\User;
use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\Message;
use Illuminate\Http\Request;
use AppChat\Chat\Classes\Services\UserService;
use October\Rain\Exception\ApplicationException as ApplicationException;


class ChatService 
{
    public static function isUserInChat($chatId, $user)
    {
        $chat = Chat::where('id', $chatId)->firstOrFail();

        if (!$chat->users->contains($user->id)) {
            throw new ApplicationException('You are not part of this chat');
        }

        return $chat;
    }

    public static function isMessageInChat($messageId, $chat)
    {
        $message = Message::where('id', $messageId)->firstOrFail();
        
        if (!$chat->messages->contains($message->id)) {
            throw new ApplicationException('You must input valid message ID');
        } 

        return $message;
    }
}

