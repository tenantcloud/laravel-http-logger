<?php


namespace TenantCloud\LaravelHttpLogger;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use TenantCloud\LaravelHttpLogger\Contracts\DriverContract;
use TenantCloud\LaravelHttpLogger\Contracts\HttpLoggerContract;

/**
 * Class HttpLoggerDefault
 *
 * @package TenantCloud\LaravelHttpLogger
 */
class HttpLogger implements HttpLoggerContract
{
	/**
	 * @var $data array
	 */
	private $data;
	/**
	 * @var DriverContract
	 */
	private $driver;

	/**
	 * HttpLogger constructor.
	 *
	 * @param DriverContract $driver
	 */
	public function __construct(DriverContract $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * @return array
	 */
	public function getData():array
	{
		return $this->data;
	}

	/**
	 * @param mixed $data
	 */
	public function setData(array $data): void
	{
		$this->data = $data;
	}

	/**
	 * @param array $newData
	 */
	public function pushData(array $newData): void
	{
		$this->setData(array_merge($this->getData(), $newData));
	}

	/**
	 * @param Request $request
	 * @return mixed|void
	 * @todo add filtering inside objects
	 */
	public function handleRequest(Request $request)
	{
		$files = array_map(function (UploadedFile $file) {
			return $file->path();
		}, iterator_to_array($request->files));

		$data = [
			'user_id' => auth()->id(),
			'remote_addr' => $request->ip(),
			'method' => strtolower($request->getMethod()),
			'uri' => $request->getPathInfo(),
			'files' => $files,
			'http_referer' => $request->header('Referer'),
			'http_user_agent' => $request->header('User-Agent'),
			'http_x_forwarded_for' => $request->header('X-Forwarded-For'),
			'request_body' => $request->except(config('http-logger.except')),
			'time_local' => $request->server('REQUEST_TIME')
		];

		$this->setData($data);
	}

	/**
	 * @param Response $response
	 */
	public function handleResponse(Response $response): void
	{
		$data = [
			'status' => $response->getStatusCode(),
			'request_time' => microtime(true) - LARAVEL_START
		];

		$this->pushData($data);
	}

	/**
	 * @return mixed
	 */
	public function log(): void
	{
		// If batching is enabled then check if Limit is reached.
		if (config('http-logger.batching.enabled')) {
			/** @var LogCacheService $cacheService */
			$cacheService = app(LogCacheService::class);

			//save record
			$cacheService->save($this->getData());

			// if limit was reached then release
			if ($cacheService->limitIsReached()) {
				$this->driver->fireBatch($cacheService->release());
			}
		} else {
			// If disabled then send it directly
			$this->driver->fire($this->getData());
		}
	}
}
