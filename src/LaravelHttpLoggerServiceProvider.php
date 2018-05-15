<?php

namespace TenantCloud\LaravelHttpLogger;

use Illuminate\Support\ServiceProvider;
use TenantCloud\LaravelHttpLogger\Contracts\DriverContract;
use TenantCloud\LaravelHttpLogger\Contracts\HttpLoggerContract;

/**
 * Class LaravelHttpLoggerServiceProvider
 *
 * @package TenantCloud\LaravelHttpLogger
 */
class LaravelHttpLoggerServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__.'/../config/http-logger.php' => config_path('http-logger.php'),
			], 'config');
		}

		$this->app->singleton(HttpLoggerContract::class, HttpLogger::class);
		/**
		 * Selected driver that will handle all http requests
		 * By default it is logged into simple Log file
		 */
		$this->app->singleton(DriverContract::class, config('http-logger.default'));
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(__DIR__.'/../config/http-logger.php', 'http-logger');
	}
}
