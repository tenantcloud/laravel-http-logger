<?php

namespace Tests;

use TenantCloud\LaravelHttpLogger\Sanitization;

/**
 * Class TestSanitizeFunction
 * @package Tests
 */
class TestSanitizeFunction extends TestCase
{
	/**
	 * @test
	 */
	public function general_checks()
	{
		$result = Sanitization::sanitize([
			'user' => [
				'password' => 12345,
				'password_confirm' => 123456,
				'password_current' => 12345,
				'password_other_field' => 'other_field',
				'regular_field' => 'some_random_text'
			]
		]);

		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'user.password'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':******', array_get($result, 'user.password_confirm'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'user.password_current'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':***********', array_get($result, 'user.password_other_field'));
		$this->assertEquals('some_random_text', array_get($result, 'user.regular_field'));

	}

	/**
	 * @test
	 */
	public function it_should_test_one_level_array()
	{
		$result = Sanitization::sanitize([
			'password' => 12345,
			'password_confirm' => 123456,
			'password_current' => 12345,
			'password_other_field' => 'other_field',
			'regular_field' => 'some_random_text'
		]);

		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'password'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':******', array_get($result, 'password_confirm'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'password_current'));
		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':***********', array_get($result, 'password_other_field'));
		$this->assertEquals('some_random_text', array_get($result, 'regular_field'));
	}

	/**
	 * @test
	 */
	public function it_should_test_multi_level_array()
	{
		$result = Sanitization::sanitize([
			'obj' => [
				'obj2' => [
					'obj3' => [
						'obj4' => [
							'password_confirm' => '12345',
							'not_sanitize' => 'not_sanitize'
						]
					]
				]
			]
		]);

		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'obj.obj2.obj3.obj4.password_confirm'));
		$this->assertEquals('not_sanitize', array_get($result, 'obj.obj2.obj3.obj4.not_sanitize'));
	}

	/**
	 * @test
	 */
	public function it_should_check_for_reserved_words()
	{
		$result = Sanitization::sanitize([
			'key' => 'john',
			'value' => 'doe',
			'string' => 'value',
			'array' => 'object'
		]);

		$this->assertEquals('john', $result['key']);
		$this->assertEquals('doe', $result['value']);
		$this->assertEquals('value', $result['string']);
		$this->assertEquals('object', $result['array']);
	}

	/**
	 * @test
	 */
	public function it_should_check_empty_array()
	{
		$result = Sanitization::sanitize([]);

		$this->assertEquals([], $result);

		$result = Sanitization::sanitize([[], []]);

		$this->assertEquals([[],[]], $result);
	}

	/**
	 * @test
	 */
	public function it_should_test_array_keys_that_should_be_excepted()
	{
		$result = Sanitization::sanitize([
			'password' => [
				'password_confirmation' => [
					'password_other' => [
						'key' => [
							'password_confirm' => '12345',
							'not_sanitize' => 'not_sanitize'
						]
					]
				]
			]
		]);

		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':*****', array_get($result, 'password.password_confirmation.password_other.key.password_confirm'));
		$this->assertEquals('not_sanitize', array_get($result, 'password.password_confirmation.password_other.key.not_sanitize'));
	}

	/**
	 * @test
	 */
	public function it_should_sanitize_long_value()
	{
		$result = Sanitization::sanitize([
			"isBase64" => true,
			"password" => "string_that_should_be_longer_than_twenty_characters",
			"type" => "6"
		]);

		$this->assertEquals(Sanitization::SANITIZE_PREFIX . ':' . str_repeat('*', 20), $result['password']);
	}
}
