<?php


namespace TenantCloud\LaravelHttpLogger\Contracts;


/**
 * Interface DriverContract
 *
 * @package TenantCloud\LaravelHttpLogger\Contracts
 */
interface DriverContract
{
	/**
	 * Handle one record
	 * Used when batch option is disabled
	 *
	 * @param array $data
	 * @return void
	 */
	public function fire(array $data): void;

	/**
	 * Handle batch of records.
	 * Used when batch option is enabled
	 *
	 * @param array $data
	 * @return void
	 */
	public function fireBatch(array $data): void;
}
