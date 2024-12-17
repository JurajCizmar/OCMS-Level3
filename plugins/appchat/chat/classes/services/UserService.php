<?php namespace AppChat\Chat\Classes\Services;

use AppChat\Chat\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public static function getUserByToken($token)
    {
        return User::where('token', $token)->firstOrFail();
    }

    public static function getTokenFromAuth(Request $request)
    {
        $auth_header = $request->header('Authorization');

        if ($auth_header && str_starts_with($auth_header, 'Bearer ')) {
            
            $token = substr($auth_header, 7);

        } else {
            $token = NULL;
        }
        return $token;
    }

    public static function getUserFromRequest(Request $request)
    {
        $token = UserService::getTokenFromAuth($request);
        return UserService::getUserByToken($token);
    }
}