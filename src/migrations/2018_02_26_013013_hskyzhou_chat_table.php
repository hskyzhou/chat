<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUserFriendsTable.
 */
class HskyzhouChatTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*朋友群组*/
		Schema::create('friend_groups', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable()->default('')->comment('朋友群组名称');
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment("用户id");
			/*添加外键*/
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->timestamps();
		});

		/*用户好友表*/
		Schema::create('friends', function(Blueprint $table) {
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户id，添加者');
			$table->unsignedInteger('friend_id')->nullable()->default(0)->comment('用户好友id,接受者');
			$table->unsignedInteger('friend_group_id')->nullable()->default(0)->comment('好友所属群组');
			/*添加外键*/
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('friend_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->timestamps();
		});

		/*用户好友间消息*/
		Schema::create('friend_messages', function(Blueprint $table) {
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户id，添加者');
			$table->unsignedInteger('friend_id')->nullable()->default(0)->comment('用户好友id,接受者');
			/*添加外键*/
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('friend_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

			$table->text('content')->comment("消息内容");
			$table->tinyInteger('is_read')->default(2)->comment("是否已读, 1-已读，2-未读");
			$table->timestamps();
		});

		/*用户申请好友*/
		Schema::create('friend_applies', function(Blueprint $table) {
			$table->increments('id')->comment('自增长id');
			$table->unsignedInteger('user_id')->nullable()->default(0)->comment('用户id，添加者');
			$table->unsignedInteger('friend_id')->nullable()->default(0)->comment('用户好友id,接受者');
			$table->text('remark')->nullable()->comment('申请内容');
			$table->string('friend_group_id')->nullable()->default(0)->comment('好友所属群组');
			/*添加外键*/
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('friend_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

			$table->tinyInteger('is_agree')->nullable()->default(3)->comment("是否接受好友,1-同意,2-不同意, 3-初始值");
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
		Schema::dropIfExists('friend_groups');
		Schema::dropIfExists('friends');
		Schema::dropIfExists('friend_messages');
		Schema::dropIfExists('friend_applies');
	}
}
