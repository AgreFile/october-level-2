<?php namespace AppUser\User\Updates;

use Brick\Math\BigInteger;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateUsersTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration
{
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appuser_user_users', function(Blueprint $table) {
            $table->id();
            $table->string("username");
            $table->string("password");
            $table->string("token",256)->nullable(); // REVIEW - Tip - Väčšinou je lepšie použiť ->nullable() ako ->default("")
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        if (Schema::hasTable('applogger_logger_logs')) {
            Schema::table('applogger_logger_logs', function (Blueprint $table) {
                $table->dropForeign(['user_id']); // Drop the foreign key constraint
            });
        }

        Schema::dropIfExists('appuser_user_users');
    }
};
