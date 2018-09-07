<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use Psr\Http\Message\ResponseInterface;

class UsersClient extends AbstractClient
{

	public function getAll(): ResponseInterface
	{
		return $this->client->request('GET', 'users');
	}

}
