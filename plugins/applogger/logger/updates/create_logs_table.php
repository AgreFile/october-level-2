<?php
namespace AppLogger\Logger\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use AppUser\User\Models\User;
/**
 * CreateLogsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        if (!Schema::hasTable("applogger_logger_logs")) {
            Schema::create('applogger_logger_logs', function (Blueprint $table) {
                $table->id();
                $table
                    ->foreignIdFor(User::class)
                    ->nullable()
                    ->constrained("appuser_user_users")
                    ->cascadeOnDelete();
                $table->timestamps();
                $table->boolean("isLate");
            });
        }
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('applogger_logger_logs');
    }
};
