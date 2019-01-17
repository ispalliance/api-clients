<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\UserClient;

final class UserRequestor extends BaseRequestor
{

	/** @var UserClient */
	private $client;

	public function __construct(UserClient $client)
	{
		$this->client = $client;
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

}
