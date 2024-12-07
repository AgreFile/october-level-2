<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Models\User;
use Illuminate\Routing\Controller;
use AppUser\User\Services\AuthService;
use Exception;
use Hash;
// use Input;
use Response;

class UsersController extends Controller
{
    public function registerUser()
    {
        $NewUser = new User();
        $NewUser->username = input("username"); 
        $NewUser->password = input("password"); 

        $NewUser->token = "";// token gets updated in AuthService
        $NewUser->save();

        $JwtToken = AuthService::create_new_jwt_token($NewUser->id);

        $response = Response::make();
        return $response->withCookie('token', $JwtToken, 3600, "/", null, true, true);
    }

    public function loginUser()
    {
        $UserQuery = User::where("username", input("username"))->first();

        if (!$UserQuery) {
            throw new Exception("User doesnt exist",400);
        }

        if (!Hash::check(input("password"), $UserQuery->password)) {
            throw new Exception("Incorrect password",400);
        }

        $UserQuery = User::where("username", input("username"))->first();

        $JwtToken = AuthService::create_new_jwt_token($UserQuery->id);

        $response = Response::make();
        return $response->withCookie('token', $JwtToken, 3600, "/", null, true, true);
    }

    public function logOut()
    {
        $userData = AuthService::get_user_with_cookie();

        if ($userData) {
            $userData->update(["token" => ""]);
            $response = Response::make("Successfully logged out", 200);
            return $response->withoutCookie("token");
        }else {
            $response = Response::make("Already logged out or your cookie was expired", 200);
            return $response->withoutCookie("token"); //just in case
        }
    }
}