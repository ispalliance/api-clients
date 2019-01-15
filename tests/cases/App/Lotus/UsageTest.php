<?php declare(strict_types = 1);

namespace Tests\Cases\App\Lotus;

use ISPA\ApiClients\App\Lotus\Client\UserClient;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use PHPUnit\Framework\TestCase;

final class UsageTest extends TestCase
{

	public function testCall(): void
	{
		$this->markTestSkipped('Manual testing only');

		// Change base_uri and X-Api-Token values
		$config = [
			'app' => [
				'lotus' => [
					'http' => [
						'base_uri' => 'http://localhost:8080/api/v1/',
						'headers' => [
							'X-Api-Token' => 'TOKEN',
						],
					],
				],
			],
		];
		$guzzle = (new GuzzleFactory($config))->create('lotus');
		$client = new UserClient($guzzle);
		$requestor = new UserRequestor($client);

		$res = $requestor->list();

		$this->assertGreaterThan(0, count($res));
	}

}
