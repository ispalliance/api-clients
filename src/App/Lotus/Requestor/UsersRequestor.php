<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use Psr\Http\Message\ResponseInterface;

class UsersRequestor extends BaseRequestor
{

	public function getAll(): ResponseInterface
	{
		return $this->client->get('users');
	}

}
