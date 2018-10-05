<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use Psr\Http\Message\ResponseInterface;

class AccountingEntityRequestor extends BaseRequestor
{

	public function getAll(): ResponseInterface
	{
		return $this->client->get('accounting-entity');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->get(sprintf('accounting-entity/%s', (string) $id));
	}

	public function getAllBanks(): ResponseInterface
	{
		return $this->client->get('accounting-entity-bank');
	}

	/**
	 * @param string|int $id
	 */
	public function getBankById($id): ResponseInterface
	{
		return $this->client->get(sprintf('accounting-entity-bank/%s', (string) $id));
	}

}
