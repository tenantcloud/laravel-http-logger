<?php


namespace TenantCloud\LaravelHttpLogger;

/**
 * Class Sanitization
 * @package TenantCloud\LaravelHttpLogger
 */
class Sanitization
{
	/**
	 * Used to inform user that value was sanitized.
	 * Followed by asterisks
	 */
	public const SANITIZE_PREFIX = '[filtered]';

	/**
	 * Sanitize selected fields recursively
	 *
	 * @param array $data
	 * @return array
	 */
	public static function sanitize(array $data): array
	{
		array_walk_recursive($data, [__CLASS__, 'sanitize_helper']);

		return $data;
	}

	/**
	 * Helper method for array_walk_recursive
	 * Replaces certain values with asterisks
	 *
	 * @param $value
	 * @param $key
	 */
	public static  function sanitize_helper(&$value, $key) {
		if (is_string($key)) {
			foreach (config('http-logger.except') as $exceptKey) {
				if (strpos($key, $exceptKey) !== false) {
					$value = self::SANITIZE_PREFIX . ':' . str_repeat("*", strlen($value));
					break;
				}
			}
		}
	}
}
