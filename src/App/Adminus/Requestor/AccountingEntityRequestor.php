<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\Client\AccountingEntityClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class AccountingEntityRequestor extends AbstractRequestor
{

	/** @var AccountingEntityClient */
	private $client;

	public function __construct(AccountingEntityClient $client)
	{
		$this->client = $client;
	}

	public function getAll(): ResponseInterface
	{
		return $this->client->getAll();
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->getById($id);
	}

	public function getAllBanks(): ResponseInterface
	{
		return $this->client->getAllBanks();
	}

	/**
	 * @param string|int $id
	 */
	public function getBankById($id): ResponseInterface
	{
		return $this->client->getBankById($id);
	}

}
