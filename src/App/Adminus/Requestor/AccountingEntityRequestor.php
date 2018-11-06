<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\Client\AccountingEntityClient;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\Domain\AbstractRequestor;

class AccountingEntityRequestor extends AbstractRequestor
{

	/** @var AccountingEntityClient */
	private $client;

	public function __construct(AccountingEntityClient $client)
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

	/**
	 * @return mixed[]
	 */
	public function getAllBanks(): array
	{
		$resp = $this->client->getAllBanks();

		$this->assertResponse($resp, [200, 404]);

		return ResponseDataExtractor::extractData($resp);
	}

	/**
	 * @param string|int $id
	 * @return mixed[]
	 */
	public function getBankById($id): array
	{
		$resp = $this->client->getBankById($id);

		$this->assertResponse($resp, [200, 404]);

		return ResponseDataExtractor::extractData($resp);
	}

}
