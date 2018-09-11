<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use Psr\Http\Message\ResponseInterface;

class UserRequestor extends BaseRequestor
{

	public function getAll(): ResponseInterface
	{
		return $this->client->get('user');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->get(sprintf('user/%s', (string) $id));
	}

}
