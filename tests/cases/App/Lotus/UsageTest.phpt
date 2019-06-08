<?php declare(strict_types = 1);

namespace Tests\Cases\App\Lotus;

use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Client\UserClient;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Http\Guzzle\GuzzleClient;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use PHPUnit\Framework\TestCase;

final class UsageTest extends TestCase
{

	/** @var GuzzleClient */
	private $guzzle;

	public function setUp(): void
	{
		// Change base_uri and X-Api-Token values
		$config = [
			'app' => [
				'lotus' => [
					'http' => [
						'base_uri' => 'http://localhost:8000/api/v1/',
						'headers' => [
							'X-Api-Token' => 'TOKEN',
						],
					],
				],
			],
		];

		$this->guzzle = (new GuzzleFactory($config))->create('lotus');
	}

	public function testListUsers(): void
	{
		$client = new UserClient($this->guzzle);
		$requestor = new UserRequestor($client);

		$res = $requestor->list();
		$this->assertGreaterThan(0, count($res));
	}

	public function testListProcesses(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->listProcesses();
		$this->assertGreaterThan(0, count($res));
	}

	public function testListProcessesByVariables(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->listProcessesByVariables(['processes1' => 73]);
		$this->assertGreaterThan(0, count($res));
	}

	public function testStartProcess(): void
	{
		$client = new ProcessClient($this->guzzle);
		$requestor = new ProcessRequestor($client);

		$res = $requestor->startProcess(1);
		$this->assertEquals(1, $res['template']['id']);
	}

}
