<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use Psr\Http\Message\ResponseInterface;

class AccountingEntityClient extends AbstractClient
{

	public function getAll(): ResponseInterface
	{
		return $this->client->request('GET', 'accounting-entity');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->request('GET', sprintf('accounting-entity/%s', (string) $id));
	}

	public function getAllBanks(): ResponseInterface
	{
		return $this->client->request('GET', 'accounting-entity-bank');
	}

	/**
	 * @param string|int $id
	 */
	public function getBankById($id): ResponseInterface
	{
		return $this->client->request('GET', sprintf('accounting-entity-bank/%s', (string) $id));
	}

}
