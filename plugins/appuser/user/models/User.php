<?php namespace AppUser\User\Models;

use Model;
use Hash;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;

    /**
     * @var string table name
     */
    public $table = 'appuser_user_users';

    public $hasMany = [
        'logs' => \AppLogger\Logger\Models\Log::class
    ];

    protected $hashable = ["password"];

    /**
     * @var array rules for validation
     */
    public $rules = [
        'password' => ['required:create'],
        'username' => ['required:create', "between:3,32", "alpha_dash", "unique"],
    ];
}
