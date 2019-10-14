<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class AccountingEntityClient extends AbstractHttpClient
{

	public function getAll(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'accounting-entity');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('accounting-entity/%s', (string) $id));
	}

	public function getAllBanks(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'accounting-entity-bank');
	}

	/**
	 * @param string|int $id
	 */
	public function getBankById($id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('accounting-entity-bank/%s', (string) $id));
	}

}
