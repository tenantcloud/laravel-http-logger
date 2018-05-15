<?php


namespace TenantCloud\LaravelHttpLogger\Drivers;

use Illuminate\Support\Facades\Log;
use TenantCloud\LaravelHttpLogger\Contracts\DriverContract;

/**
 * Class DefaultDriver
 *
 * @package TenantCloud\LaravelHttpLogger\Drivers
 */
class DefaultDriver implements DriverContract
{
	/**
	 * @param array $data
	 * @return void
	 */
	public function fire(array $data): void
	{
		Log::info('Logged', $data);
	}

	/**
	 * @param array $data
	 * @return void
	 */
	public function fireBatch(array $data): void
	{
		foreach ($data as $record) {
			Log::info('Logged from batch', $record);
		}
	}
}
