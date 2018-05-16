<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TenantCloud\LaravelHttpLogger\LaravelHttpLoggerServiceProvider;

/**
 * Class TestCase
 * @package TenantCloud\LaravelHttpLogger
 */
abstract class TestCase extends OrchestraTestCase
{
	/**
	 * @param \Illuminate\Foundation\Application $app
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [LaravelHttpLoggerServiceProvider::class];
	}
}
