<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Models\User;
use Cookie;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use AppUser\User\Services\AuthService;
use Input;
use Response;

class UsersController extends Controller
{
    public function registerUser()
    {
        $NewUser = new User();
        $NewUser->username = Input::get("username"); // REVIEW - dá sa to aj takto "input('username')" a máš o jeden import menej :DD
        $NewUser->password = Hash::make(Input::get("password")); // REVIEW - Ak by si toto robil cez 'hashable' ako som spomínal v User.php, tak tu nemusíš hashovať

        $NewUser->token = "";// token gets updated in AuthService
        $NewUser->save();

        $JwtToken = AuthService::create_new_jwt_token($NewUser->id);

        $response = Response::make();
        return $response->withCookie('token', $JwtToken, 3600, "/", null, true, true);
    }

    public function loginUser()
    {
        // REVIEW - Lepšie je použiť ->first() ako ->get(), tým pádom nižšie nemusíš robiť '$UserQuery[0]' lebo namiesto array sa ti vráti rovno objekt
        $UserQuery = User::where("username", Input::get("username"))->get();

        $JwtToken = AuthService::create_new_jwt_token($UserQuery[0]->id);

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