<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\UserClient;

/**
 * @property UserClient $client
 */
final class UserRequestor extends BaseRequestor
{

	public function __construct(UserClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function list(int $limit = 10, int $offset = 0): array
	{
		$response = $this->client->list($limit, $offset);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function getById(int $id): array
	{
		$response = $this->client->getById($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function getByEmail(string $email): array
	{
		$response = $this->client->getByEmail($email);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param int[] $userIds
	 * @return mixed[]
	 */
	public function combineUserGroup(string $gid, array $userIds, bool $includeSystemUsers = FALSE, bool $includeBlockedUsers = FALSE): array
	{
		$response = $this->client->combineUserGroup($gid, $userIds, $includeSystemUsers, $includeBlockedUsers);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function getMentions(string $query): array
	{
		$response = $this->client->getMentions($query);

		return $this->processResponse($response)->getData();
	}

}
