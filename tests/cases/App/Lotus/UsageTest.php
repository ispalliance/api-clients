<?php declare(strict_types = 1);

namespace Tests\Cases\ISPA\ApiClients\App\Lotus;

use GuzzleHttp\Client;
use ISPA\ApiClients\App\Lotus\LotusClient;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class UsageTest extends TestCase
{

	protected function setUp(): void
	{
		$this->markTestSkipped('This is manual test');
	}

	public function testClient(): void
	{
		$guzzle = new Client([
			'base_uri' => 'http://localhost:8000/api/v1/',
		]);

		$lotusClient = new LotusClient($guzzle);

		$res = $lotusClient->get('users');
		$this->assertInstanceOf(ResponseInterface::class, $res);

		$data = json_decode($res->getBody()->getContents(), TRUE);
		$this->assertEquals('success', $data['status']);
	}

	public function testUserRequestor(): void
	{
		$guzzle = new Client([
			'base_uri' => 'http://localhost:8000/api/v1/',
		]);

		$lotusClient = new LotusClient($guzzle);
		$usersRequestor = new UsersRequestor($lotusClient);

		$res = $usersRequestor->getAll();
		$this->assertInstanceOf(ResponseInterface::class, $res);

		$data = json_decode($res->getBody()->getContents(), TRUE);
		$this->assertEquals('success', $data['status']);
	}

}
