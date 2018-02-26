<?php 

namespace HskyZhou\Chat;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	public function register()
	{
		/*合并配置文件*/
		$this->mergeConfigFrom(__DIR__ . '/config/chat.php', 'chat');
	}

	public function boot()
	{
		/*发布配置文件*/
		$this->publishes([
			__DIR__ . '/config/chat.php' => config_path('chat.php'),
		]);

		/*加载路由*/
		$this->loadRoutesFrom(__DIR__ . '/routes/route.php');

		/*加载数据库迁移文件*/
		$this->loadMigrationsFrom(__DIR__ . '/migrations');
	}
}