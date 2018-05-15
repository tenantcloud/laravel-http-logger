<?php

return [
	/**
	 * Disable or enable logging
	 */
	'enabled' => true,

	/**
	 * Driver which will be used to fire logging
	 * Available options:
	 * \TenantCloud\LaravelHttpLogger\Drivers\DefaultDriver::class
	 * \TenantCloud\LaravelHttpLogger\Drivers\ExternalDriver::class
	 */
	'default' => \TenantCloud\LaravelHttpLogger\Drivers\DefaultDriver::class,

	/**
	 * Available params: 'get', 'post', 'put', 'patch', 'delete' etc.
	 */
	'except_methods' => [],

	/**
	 * Sanitize fields.
	 */
	'except' => [
		'password',
		'password_confirmation',
	],

	/**
	 * Save record into cache and send only when batch limit is reached.
	 * Avoid too many requests at the same time
	 * Works only with Redis driver.
	 */
	'batching' => [
		'enabled' => true,
		'limit' => 5
	],

	/**
	 * Drivers special options
	 */
	'drivers' => [
		'external' => [
			'api_key' => env('HTTP_LOGGER_API_KEY'),
			'url' => env('HTTP_LOGGER_URL'),
			'queue' => 'default'
		]
	]
];
