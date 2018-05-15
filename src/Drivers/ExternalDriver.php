<?php


namespace TenantCloud\LaravelHttpLogger\Drivers;

use TenantCloud\LaravelHttpLogger\Contracts\DriverContract;
use TenantCloud\LaravelHttpLogger\Jobs\SendLogJob;

/**
 * Class ExternalDriver
 *
 * @package TenantCloud\LaravelHttpLogger\Drivers
 */
class ExternalDriver implements DriverContract
{
	/**
	 * Handle one record
	 * Used when batch option is disabled
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function fire(array $data): void
	{
		$this->fireResponse([$data]);
	}

	/**
	 * Handle batch of records.
	 * Used when batch option is enabled
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function fireBatch(array $data): void
	{
		$this->fireResponse($data);
	}

	/**
	 * @param array $data
	 */
	private function fireResponse(array $data)
	{
		SendLogJob::dispatch($data)
			->onQueue(config('http-logger.drivers.external.queue', 'default'));
	}
}
