<?php namespace AppUser\User\Http\Controllers;

use AppUser\User\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use AppUser\User\Classes\Services\UserService;
use AppUser\User\Http\Resources\UserResource;
use October\Rain\Exception\ApplicationException as ApplicationException;

class UserController extends Controller
{
    public function registerNewUser()
    {
        $user = new User;
        $user->username = input('username');
        $user->password = input('password');
        $user->token = base64_encode(random_bytes(64));
        $user->save();

        return ['message' => "You have been successfully registered"];
    }

    public function login()
    {
        $username = input('username');
        $password = input('password');

        $user = User::where('username', $username)->firstOrFail();
        $hashedPassword = $user->password;

        if (Hash::check($password, $hashedPassword)) {

            if ($user->token == NULL){
                $user->token = base64_encode(random_bytes(64));
                $user->save();
            }

            return response()->json([
                'message' => "Login successful",
                'token' => $user->token,
            ]);

        } else {
            throw new ApplicationException('Login failed');
        }
    }

    public function logout(Request $request)
    {
        $currentUser = UserService::getUserFromRequest($request);

        if ($currentUser->token != NULL) {
            
            $currentUser->token = NULL;
            $currentUser->save();

            return ['message' => "You've been logged out"];
        }
    }

    // public function deleteUsers()
    // {
    //     User::truncate();
    //     return response()->json(['message' => "Users deleted successfully"]);
    // }
}