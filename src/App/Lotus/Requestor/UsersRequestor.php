<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\UsersClient;
use ISPA\ApiClients\App\Lotus\Entity\User;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Nette\Utils\Json;

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

		$data = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
		$users = [];

		foreach ($data as $item) {
			$users[] = new User($item['id']);
		}

		return $users;
	}

}
