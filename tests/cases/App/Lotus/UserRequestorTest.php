<?php declare(strict_types = 1);

namespace Tests\Cases\App\Lotus;

use ISPA\ApiClients\App\Lotus\Client\UserClient;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Tests\Cases\App\AbstractAppTestCase;

class UserRequestorTest extends AbstractAppTestCase
{

	public function testList(): void
	{
		$usersRequestor = $this->createRequestor('users.json');
		$res = $usersRequestor->list();

		$this->assertCount(10, $res);

		$this->assertEquals('first@ispalliance.cz', $res[0]['email']);
		$this->assertEquals(1, $res[0]['id']);

		$this->assertEquals('tenth@gmail.com', $res[9]['email']);
		$this->assertEquals(10, $res[9]['id']);
	}

	public function testGetById(): void
	{
		$usersRequestor = $this->createRequestor('user.json');
		$res = $usersRequestor->getById(1);

		$this->assertEquals('user@ispalliance.cz', $res['email']);
		$this->assertEquals('Leopoldus Augustus Ispus', $res['fullname']);
	}

	public function testGetByEmail(): void
	{
		$usersRequestor = $this->createRequestor('user.json');
		$res = $usersRequestor->getByEmail('user@ispalliance.cz');

		$this->assertEquals('user@ispalliance.cz', $res['email']);
		$this->assertEquals('Leopoldus Augustus Ispus', $res['fullname']);
	}

	public function testError(): void
	{
		$this->expectException(ResponseException::class);
		$this->expectExceptionMessage('API error. Status: error, Message: Client authentication failed');
		$usersRequestor = $this->createRequestor('error.json');
		$usersRequestor->getByEmail('user@ispalliance.cz');
	}

	private function createRequestor(string $file): UserRequestor
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$usersClient = new UserClient($httpClient);

		return new UserRequestor($usersClient);
	}

}
