<?php

namespace Test;

use TenantCloud\LaravelHttpLogger\HttpLogger;
use Tests\TestCase;
use Illuminate\Http\Request;

/**
 * Class TestMainFunctionality
 * @package Test
 */
class TestMainFunctionality extends TestCase
{
	/**
	 * @test
	 */
	public function it_checks_parsed_parameters()
	{
		$data = $this->generateRequest();

		$this->assertArrayHasKey('user_id', $data);
		$this->assertArrayHasKey('remote_addr', $data);
		$this->assertArrayHasKey('files', $data);
		$this->assertArrayHasKey('uri', $data);
		$this->assertArrayHasKey('request_body', $data);
		$this->assertArrayHasKey('http_user_agent', $data);
		$this->assertArrayHasKey('http_referer', $data);
		$this->assertArrayHasKey('method', $data);
	}

	/**
	 * @test
	 */

	public function it_checks_uri()
	{
		$data = $this->generateRequest();
		$this->assertEquals('/', $data['uri']);

		$data = $this->generateRequest('https://example.com/users');
		$this->assertEquals('/users', $data['uri']);

		$data = $this->generateRequest('https://example.com/users?status=1');
		$this->assertEquals('/users', $data['uri']);

		$data = $this->generateRequest('https://example.com/users?status=1&sortby=latest');
		$this->assertEquals('/users', $data['uri']);
	}

	/**
	 * @test
	 */
	public function it_checks_methods()
	{
		$data = $this->generateRequest('https://example.com/users/1', 'delete');
		$this->assertEquals('/users/1', $data['uri']);
		$this->assertEquals('delete', $data['method']);
	}

	/**
	 * @param string $url
	 * @return array
	 */
	private function generateRequest(string $url = 'https://example.com', string $method = 'GET'): array
	{
		$request = Request::create($url, $method);

		$logger = app(HttpLogger::class);
		$logger->handleRequest($request);

		return $logger->getData();
	}
}
