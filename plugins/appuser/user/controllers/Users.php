<?php
namespace AppUser\User\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use AppLogger\Logger\Models\Log;
use AppUser\User\Models\User;

/**
 * Users Backend Controller
 *
 * @link https://docs.octobercms.com/3.x/extend/system/controllers.html
 */
class Users extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var array required permissions
     */
    public $requiredPermissions = ['appuser.user.users'];

    /**
     * __construct the controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->makeLists();

        BackendMenu::setContext('AppUser.User', 'user', 'users');
    }

    public function index()
    {
    }

    public function logs($id = null)
    {
        if ($id) {
            $logs = Log::where("user_id", $id);

            return $this->makePartial("partials/logs", ["userId" => $id, "logs" => $logs]);
        } else {
            $users = User::all();

            return $this->makePartial("partials/all_logs", ["userId" => $id, "users" => $users]);
        }
    }
}
