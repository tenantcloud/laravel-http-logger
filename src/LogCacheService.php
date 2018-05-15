<?php


namespace TenantCloud\LaravelHttpLogger;

use Illuminate\Support\Facades\Redis;

/**
 * Class LogCacheService
 *
 * @package TenantCloud\LaravelHttpLogger
 */
class LogCacheService
{
	/**
	 * Key that is used for caching
	 */
	private const CACHE_KEY = 'http_log';


	/**
	 * Check if limit of record was reached.
	 * Returns if count of records that are saved is >= than value in config
	 *
	 * @return int
	 */
	public function limitIsReached(): int
	{
		return Redis::lLen(self::CACHE_KEY) >= config('http-logger.batching.limit');
	}

	/**
	 * Save encoded array into Redis DB
	 *
	 * @param array $record
	 */
	public function save(array $record): void
	{
		Redis::rPush(self::CACHE_KEY, json_encode($record));
	}

	/**
	 * Get all records that are saved.
	 * Return array and clear Redis key
	 *
	 * @return mixed
	 */
	public function release(): array
	{
		// Grab all cached records
		$records = Redis::lRange(self::CACHE_KEY, 0, -1);
		// clear records
		Redis::lTrim(self::CACHE_KEY, -1, 0);

		return array_map(function ($record) {
			return json_decode($record, true);
		}, $records);
	}
}
