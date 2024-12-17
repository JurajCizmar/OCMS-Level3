<?php namespace AppUser\User;

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
            'name' => 'User',
            'description' => 'Plugin for managing users',
            'author' => 'AppUser',
            'icon' => 'icon-address-book'
        ];
    }

    /**
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        // return []; // Remove this line to activate

        return [
            'user' => [
                'label' => 'User',
                'url' => Backend::url('appuser/user/users'),
                'icon' => 'icon-address-book',
                'permissions' => ['appuser.user.*'],
                'order' => 500,
            ],
        ];
    }
}
