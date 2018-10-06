<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractClient
{

	public function getAll(): ResponseInterface
	{
		return $this->client->request('GET', 'user');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->request('GET', sprintf('user/%s', (string) $id));
	}

}
