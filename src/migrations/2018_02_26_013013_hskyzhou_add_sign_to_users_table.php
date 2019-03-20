<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserFriendsTable.
 */
class HskyzhouAddSignToUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*群组*/
		Schema::table('users', function(Blueprint $table) {
			$table->string('sign');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sign');
        });
	}
}
