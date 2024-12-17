<?php namespace AppChat\Chat\Http\Controllers;

use AppChat\Chat\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use AppChat\Chat\Classes\Services\UserService;
use AppChat\Chat\Http\Resources\UserResource;
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
        
        // REVIEW - Tip - stačí aj "return ['message' => "You have been successfully registered"]" je to to isté, lebo OCMS automaticky rozpozná že je to json
        return response()->json(['message' => "You have been successfully registered"]);
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
            return response()->json(['message' => "You've been logged out"]);
        }
    }

    // public function deleteUsers()
    // {
    //     User::truncate();
    //     return response()->json(['message' => "Users deleted successfully"]);
    // }
}