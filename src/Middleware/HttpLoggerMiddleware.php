<?php


namespace TenantCloud\LaravelHttpLogger\Middleware;

use Closure;
use Illuminate\Http\Request;
use TenantCloud\LaravelHttpLogger\Contracts\HttpLoggerContract;

/**
 * Class HttpLoggerMiddleware
 *
 * @package TenantCloud\LaravelHttpLogger\Middleware
 */
class HttpLoggerMiddleware
{
	/**
	 * @var HttpLoggerContract
	 */
	private $httpLogger;

	/**
	 * HttpLoggerMiddleware constructor.
	 *
	 * @param HttpLoggerContract $httpLogger
	 */
	public function __construct(HttpLoggerContract $httpLogger)
	{
		$this->httpLogger = $httpLogger;
	}

	/**
	 * @param Request $request
	 * @param Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		// first check if logger was enabled and
		// also filter if request method should be logged
		$toLog = config('http-logger.enabled') && !in_array(strtolower($request->getMethod()), config('http-logger.except_methods'));
		// handle request first
		if ($toLog) {
			$this->httpLogger->handleRequest($request);
		}

		$response = $next($request);

		// then handle response to get Response code,
		if ($toLog) {
			$this->httpLogger->handleResponse($response);
			$this->httpLogger->log();
		}

		return $response;
	}
}
