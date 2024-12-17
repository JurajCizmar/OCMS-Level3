<?php namespace AppUser\User\Classes\Services;

use AppUser\User\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public static function getUserByToken($token)
    {
        return User::where('token', $token)->firstOrFail();
    }

    public static function getTokenFromAuth()
    {
        return request()->bearerToken();
    }

    public static function getUserFromRequest()
    {
        $token = UserService::getTokenFromAuth();
        return UserService::getUserByToken($token);
    }
}