<?php
namespace AppLogger\Logger\Http\Controllers;

use AppLogger\Logger\Models\Log;
use AppUser\User\Models\User;
use AppUser\User\Services\AuthService;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class LogsController extends Controller
{
    public function log()
    {
        $islate = Carbon::now()->hour >= 8;

        $NewLog = new Log();
        $NewLog->user_id = AuthService::get_userid_from_cookie();
        $NewLog->isLate = $islate;
        $NewLog->save();

        return response()->json(["log" => $NewLog->get()[$NewLog->id-1]],200);
    }

    public function getLogs()
    {
        $userData = AuthService::get_user_with_cookie();

        return response()->json(["logs" => $userData->get()[0]->logs],200);
    }
}