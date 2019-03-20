<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserFriendsTable.
 */
class HskyzhouAddInitSkinToUsersTable extends Migration
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
			$table->string('init_skin');
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
            $table->dropColumn('init_skin');
        });
	}
}
