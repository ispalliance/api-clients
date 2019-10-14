<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractHttpClient
{

	public function getAll(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'user');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('user/%s', (string) $id));
	}

}
