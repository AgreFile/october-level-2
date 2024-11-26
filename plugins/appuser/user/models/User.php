<?php namespace AppUser\User\Models;

use Model;

/**
 * User Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class User extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appuser_user_users';

    public $hasMany = [
        'logs' => \AppLogger\Logger\Models\Log::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
