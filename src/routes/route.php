<?php 

Route::group(['middleware' => 'web', 'prefix' => 'chat', 'as' => "chat.", 'namespace' => 'HskyZhou\Chat\Controllers'], function($router) {
	/*初始化数据*/
	$router->group(['prefix' => 'init', 'as' => "init."], function($router) {
		/*添加朋友*/
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
		/*绑定uid和client_id*/
		$router->get('bind', [
			'uses' => 'GatewayController@bind',
			'as' => 'bind'
		]);
		
		/*发送消息*/
		$router->post('send', [
			'uses' => 'GatewayController@send',
			'as' => 'send'
		]);
	});
});