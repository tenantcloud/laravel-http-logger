<?php

namespace TenantCloud\LaravelHttpLogger\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class SendLogJob
 *
 * @package TenantCloud\LaravelHttpLogger\Jobs
 */
class SendLogJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * Create a new job instance.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function handle()
	{
		$client = new Client();

		$client->request('POST', config('http-logger.drivers.external.url'), [
			'json' => [
				'apiKey' => config('http-logger.drivers.external.api_key'),
				'data' => $this->data
			]
		]);
	}
}
