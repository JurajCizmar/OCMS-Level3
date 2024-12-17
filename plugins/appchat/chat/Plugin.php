<?php namespace AppChat\Chat;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Chat',
            'description' => 'Plugin for chatting between users',
            'author' => 'AppChat',
            'icon' => 'icon-comments-o'
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return [
            'chat' => [
                'label' => 'Chat',
                'url' => Backend::url('appchat/chat/chats'),
                'icon' => 'icon-comments-o',
                'permissions' => ['appchat.chat.*'],
                'order' => 500,
            ],

            'emojis' => [
                'label' => 'Emojis',
                'url' => Backend::url('appchat/chat/emojis'),
                'icon' => 'icon-smile-o',
                'permissions' => ['appchat.chat.*'],
                'order' => 500,
            ],

            'messages' => [
                'label' => 'Messages',
                'url' => Backend::url('appchat/chat/messages'),
                'icon' => 'icon-envelope',
                'permissions' => ['appchat.chat.*'],
                'order' => 510,
            ],
        ];
    }
}
