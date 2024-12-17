<?php namespace AppChat\Chat\Http\Controllers;

use Illuminate\Routing\Controller;
use AppChat\Chat\Models\User;
use AppChat\Chat\Models\Message;
use AppChat\Chat\Models\Chat;
use AppChat\Chat\Models\Emoji;
use AppChat\Chat\Models\ChatUserPivot;
use AppChat\Chat\Http\Resources\UserResource;
use AppChat\Chat\Http\Resources\MessageResource;
use AppChat\Chat\Http\Resources\EmojiResource;
use AppChat\Chat\Classes\Services\UserService;
use AppChat\Chat\Classes\Services\ChatService; 
use Illuminate\Http\Request;
use Input;
use October\Rain\Support\Collection;
use October\Rain\Exception\ApplicationException as ApplicationException;
// use October\Rain\Exception\NotFoundException as NotFoundException;


class ChatController extends Controller
{
    public function getUsersIds()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    // REVIEW - Tip - Nemusíš písať "Request $request", hodikde môžeš zavolať "request()" a dostaneš tie isté dáta
    public function createNewChat(Request $request)
    {
        $currentUser = UserService::getUserFromRequest($request);

        $chatWithUser = input('id');
        $secondUser = User::where('id', $chatWithUser)->firstOrFail();

        // if ($user1->id == $user2->id) {
        //     throw new ApplicationException('Cannot create chat with yourself');
        // }

        $chat = new Chat;
        $chat->save();

        $usersIdArray = [$currentUser->id, $secondUser->id];

        foreach ($usersIdArray as $userID) {
            $chatUserPivot = ChatUserPivot::create([
                'user_id' => $userID,
                'chat_id' => $chat->id
            ]);
        }
        return response()->json(['message' => "Chat created successfully"]);
    }

    public function showUserTheirChats(Request $request)
    {
        $currentUser = UserService::getUserFromRequest($request);
        $chats = $currentUser->chats;

        $collection = new Collection();

        foreach ($chats as $chat) {
            foreach ($chat->users as $user) {
                if ($user->id !== $currentUser->id) {
                    $collection->push([
                        'chat_id' => $user->pivot->chat_id,
                        'chat_name' => $chat->name,
                        'other_user' => $user->username
                    ]);
                }
            }
        }
        return $collection;
    }

    public function nameChat(Request $request)
    {
        $chatId = input('chat_id');
        $chatName = input('chat_name');

        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser);

        $chat->name = $chatName;
        $chat->save();
        
        return response()->json(['message' => "Chat renamed successfully"]);
    }

    public function writeMessageToChat(Request $request)
    {
        $chatId = input('chat_id');
        $usersMessage = input('message');

        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser);

        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $currentUser->id,
            'message' => $usersMessage
        ]);

        return response()->json(['message' => "Message sent"]);
    }

    public function showMyChat(Request $request)
    {
        $chatId = input('chat_id');

        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser);
        $messages = Message::where('chat_id', $chat->id)->orderBy('created_at', 'desc')->get();

        return MessageResource::collection($messages);
    }

    public function showEmojis(Request $request)
    {
        $emojis = Emoji::all();
        return EmojiResource::collection($emojis);
    }

    public function reactToMessage(Request $request)
    {
        $chatId = input('chat_id');
        $reactToId = input('message_id');
        $reaction = input('reaction');

        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser);
        $emoji = Emoji::where('name', $reaction)->firstOrFail();
        $message = ChatService::isMessageInChat($reactToId, $chat);   

        $message->emoji_id = $emoji->id;
        $message->save();
        
        return response()->json(['message' => "Emoji sent"]);
    }

    public function replyToMessage(Request $request)
    {
        $chatId = input('chat_id');
        $replyToId = input('message_id');
        $replyText = input('reply');

        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser); 
        $message = ChatService::isMessageInChat($replyToId, $chat);   

        $reply = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $currentUser->id,
            'message' => $replyText,
            'parent_id' => $message->id
        ]);

        return response()->json(['message' => "Reply sent"]);
    }

    public function sendAttachment(Request $request)
    {
        $chatId = input('chat_id');
        $currentUser = UserService::getUserFromRequest($request);
        $chat = ChatService::isUserInChat($chatId, $currentUser);

        $message = Message::create([
            'chat_id' => $chat->id,
            'user_id' => $currentUser->id
        ]);

        $message->attachment = Input::file('input_file');
        $message->attachment->is_public = false;
        $message->save();

        $message->file_path = $message->attachment->getPath();
        $message->save();
        return response()->json([$message->file_path]);
    }

    public function deleteEveryChat()
    {
        ChatUserPivot::truncate();
        Chat::truncate();
        return response()->json(['message' => "Every chat deleted successfully"]);
    }

    public function test()
    {

    }
}