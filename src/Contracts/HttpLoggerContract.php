<?php


namespace TenantCloud\LaravelHttpLogger\Contracts;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface HttpLoggerContract
 *
 * @package TenantCloud\LaravelHttpLogger\Contracts
 */
interface HttpLoggerContract
{
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function handleRequest(Request $request) ;

	/**
	 * @param Response $response
	 * @return mixed
	 */
	public function handleResponse(Response $response);

	/**
	 * @return mixed
	 */
	public function log();
}
