<?php 

Route::group(['middleware' => ['web'], 'prefix' => 'chat', 'as' => "chat.", 'namespace' => 'HskyZhou\Chat\Controllers'], function($router) {
	/*默认用户相关数据*/
	$router->group(['prefix' => 'index', 'as' => "index."], function($router) {
		/*获取个人信息，用户朋友，用户组*/
		$router->get('index', [
			'uses' => 'IndexController@index',
			'as' => 'index'
		]);
	});

	/*初始化用户基础数据---比如绑定用户id，加入组*/
	$router->group(['prefix' => 'init', 'as' => "init."], function($router) {
		$router->get('index', [
			'uses' => 'InitController@index',
			'as' => 'index'
		]);
	});

	$router->group(['prefix' => 'friend', 'as' => "friend."], function($router) {
		/*添加朋友*/
		$router->post('apply', [
			'uses' => 'FriendController@apply',
			'as' => 'apply'
		]);

		/*同意添加*/
		$router->post('agree', [
			'uses' => 'FriendController@agree',
			'as' => 'agree'
		]);

		/*拒绝添加*/
		$router->post('reject', [
			'uses' => 'FriendController@reject',
			'as' => 'reject'
		]);
	});

	$router->group(['prefix' => 'group', 'as' => "group."], function($router) {
		/*加入分组*/
		$router->get('join', [
			'uses' => 'GroupController@join',
			'as' => 'join'
		]);
	});

	$router->group(['prefix' => 'gateway', 'as' => "gateway."], function($router) {
		/*发送消息*/
		$router->post('send', [
			'uses' => 'GatewayController@send',
			'as' => 'send'
		]);
	});

	/*查看成员*/
	$router->group(['prefix' => 'member', 'as' => "member."], function($router) {
		$router->get('index', [
			'uses' => 'MemberController@index',
			'as' => 'index'
		]);
	});

	/*查看成员*/
	$router->group(['prefix' => 'chatlog', 'as' => "chatlog."], function($router) {
		$router->get('index', [
			'uses' => 'ChatlogController@index',
			'as' => 'index'
		]);
	});

	/*签名控制器*/
	$router->group(['prefix' => 'sign', 'as' => "sign."], function($router) {
		$router->post('save', [
			'uses' => 'SignController@save',
			'as' => 'save'
		]);
	});

	/*背景麸皮控制器*/
	$router->group(['prefix' => 'skin', 'as' => "skin."], function($router) {
		$router->post('save', [
			'uses' => 'SkinController@save',
			'as' => 'save'
		]);
	});

	/*消息盒子*/
	$router->group(['prefix' => 'msgbox', 'as' => "msgbox."], function($router) {
		$router->get('index', [
			'uses' => 'MsgboxController@index',
			'as' => 'index'
		]);
	});

	/*查找好友*/
	$router->group(['prefix' => 'find', 'as' => "find."], function($router) {
		$router->get('index', [
			'uses' => 'FindController@index',
			'as' => 'index'
		]);
	});
});