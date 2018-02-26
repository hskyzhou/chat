<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserFriendsTable.
 */
class CreateUserFriendsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*用户朋友表*/
		Schema::create('user_friend_groups', function(Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户id');
            $table->unsignedInteger('friend_user_id')->nullable()->default(0)->comment('朋友的用户id');
            $table->integer('friend_group_id')->nullable()->default(0)->comment('朋友分组id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('friend_user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['user_id', 'friend_user_id']);
		});

		/*朋友分组表*/
		Schema::create('friend_groups', function(Blueprint $table) {
			$table->integer('id');
			$table->string('name')->nullable()->default('')->comment('分组名称');
            $table->timestamps();
		});

		/*用户群组*/
		Schema::create('user_groups', function(Blueprint $table) {
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户id');
            $table->integer('group_id')->nullable()->default(0)->comment('群组id');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('group_id')->references('id')->on('groups')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();

            $table->primary(['user_id', 'group_id']);
		});

		/*群组*/
		Schema::create('groups', function(Blueprint $table) {
			$table->integer('id');
			$table->string('name')->nullable()->default('')->comment('分组名称');
            $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('user_friend_groups');
	}
}
