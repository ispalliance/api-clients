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
						'base_uri' => 'http://localhost:8010/api/v1/',
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
		$usrClient = new UserClient($this->guzzle);
		$usrRequestor = new UserRequestor($usrClient);

		$res = $usrRequestor->list();
		$this->assertGreaterThan(0, count($res));
	}

	public function testUploadFile(): void
	{
		$procClient = new ProcessClient($this->guzzle);
		$procRequestor = new ProcessRequestor($procClient);

		$upl = $procRequestor->uploadFile(12, 'task', 'filename', 'contents');
		$this->assertEquals([], $upl);
	}

}
