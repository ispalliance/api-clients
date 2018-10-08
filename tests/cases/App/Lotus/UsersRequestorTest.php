<?php declare(strict_types = 1);

namespace Tests\Cases\App\Lotus;

use ISPA\ApiClients\App\Lotus\Client\UsersClient;
use ISPA\ApiClients\App\Lotus\Entity\User;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use Tests\Cases\App\AbstractAppTestCase;

class UsersRequestorTest extends AbstractAppTestCase
{

	public function testUserRequestor(): void
	{
		$httpClient     = $this->createTestClient(200, '[{"id": 1},{"id": 2}]');
		$usersClient    = new UsersClient($httpClient);
		$usersRequestor = new UsersRequestor($usersClient);

		$res = $usersRequestor->getAll();
		$this->assertTrue(is_array($res));
		$this->_assertUsers($res);
	}

	/**
	 * @param User[] $users
	 */
	private function _assertUsers(array $users): void
	{
		$actual = '';

		foreach ($users as $user) {
			$this->assertInstanceOf(User::class, $user);

			$actual .= $user->getId();
		}

		$this->assertEquals('12', $actual);
	}

}
