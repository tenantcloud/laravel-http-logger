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
	 * Value will be replaced with maximum characters of this number
	 */
	public const STRING_MAX_LENGTH = 20;

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
					$value = self::SANITIZE_PREFIX . ':' . str_repeat("*", self::getStringLengthToSanitize($value));
					break;
				}
			}
		}
	}

	/**
	 * Get length of value that should be sanitized
	 *
	 * @param $value
	 * @return int
	 */
	public static function getStringLengthToSanitize($value):int
	{
		$strLength = strlen($value);

		return ($strLength > self::STRING_MAX_LENGTH) ? self::STRING_MAX_LENGTH : $strLength;
	}
}
