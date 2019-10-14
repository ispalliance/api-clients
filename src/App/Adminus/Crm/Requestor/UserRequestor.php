<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Requestor;

use ISPA\ApiClients\App\Adminus\Crm\Client\UserClient;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\Domain\AbstractRequestor;

class UserRequestor extends AbstractRequestor
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
	public function getAll(): array
	{
		$resp = $this->client->getAll();

		$this->assertResponse($resp, [200, 404]);

		return ResponseDataExtractor::extractData($resp);
	}

	/**
	 * @param string|int $id
	 * @return mixed[]
	 */
	public function getById($id): array
	{
		$resp = $this->client->getById($id);

		$this->assertResponse($resp, [200, 404]);

		return ResponseDataExtractor::extractData($resp);
	}

}
