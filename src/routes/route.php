<?php 

Route::group(['middleware' => 'web', 'prefix' => 'chat', 'as' => "chat.", 'namespace' => 'HskyZhou\Chat\Controllers'], function($router) {
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
		$router->get('add', [
			'uses' => 'FriendController@add',
			'as' => 'add'
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
});