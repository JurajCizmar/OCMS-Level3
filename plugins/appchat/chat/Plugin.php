<?php namespace AppChat\Chat;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase // REVIEW - Tip - Môžeš odstrániť funkcie kde nič nie je / kde máš "return [];" aby to bolo prehľadnejšie
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Chat',
            'description' => 'No description provided yet...',
            'author' => 'AppChat',
            'icon' => 'icon-leaf'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'AppChat\Chat\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'appchat.chat.some_permission' => [
                'tab' => 'Chat',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        // return []; // Remove this line to activate

        return [
            'chat' => [
                'label' => 'Chat',
                'url' => Backend::url('appchat/chat/chats'),
                'icon' => 'icon-leaf',
                'permissions' => ['appchat.chat.*'],
                'order' => 500,
            ],

            'Emoji' => [
            'label'       => 'Emojis',
            'url'         => Backend::url('appchat/chat/emojis'),
            'icon'        => 'icon-smile-o',
            'permissions' => ['appchat.chat.*'],
            'order'       => 500,
        ],
        ];
    }
}
