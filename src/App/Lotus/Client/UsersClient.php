<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class UsersClient extends AbstractHttpClient
{

	public function getAll(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'users');
	}

}
