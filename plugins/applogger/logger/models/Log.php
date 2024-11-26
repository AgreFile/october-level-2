<?php namespace AppLogger\Logger\Models;

use Model;

/**
 * Log Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Log extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'applogger_logger_logs';

    public $belongsTo = [
        'user' => \AppUser\User\Models\User::class
    ];

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
