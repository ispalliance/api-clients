<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\UsersClient;
use ISPA\ApiClients\App\Lotus\Entity\User;
use ISPA\ApiClients\Domain\AbstractRequestor;

class UsersRequestor extends AbstractRequestor
{

	/** @var UsersClient */
	private $client;

	public function __construct(UsersClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @return User[]
	 */
	public function getAll(): array
	{
		$response = $this->client->getAll();

		$this->assertResponse($response);

		$data  = json_decode($response->getBody()->getContents(), true);
		$users = [];

		foreach ($data as $item) {
			$users[] = new User($item['id']);
		}

		return $users;
	}

}
