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

        /* REVIEW - Tu úplne nerozumiem prečo to robíš takto '$NewLog->get()[$NewLog->id-1]', po prvé by si určite nemal interagovať s ID že odčítaš, to nie je spoľahlivé
        po druhé čo sa vlastne snažíš vrátiť v tomto response? Malo by sa to dať urobiť jednoduchšie, ak sa snažíš vrátiť $NewLog tak stačí "return ['log' => $NewLog];" */
        //neviem preco ale predtym ked som to takto urobil tak to neslo, nieco som musel urobit zle vtedy
        return response()->json(["log" => $NewLog],200);
    }

    public function getLogs()
    {
        $userData = AuthService::get_user_with_cookie()->first();

        // REVIEW - Tu taktiež, malo by to ísť jednoduchšie, napr. "return ['logs' => $user->logs];"
        return response()->json(["logs" => $userData->logs],200);
    }
}