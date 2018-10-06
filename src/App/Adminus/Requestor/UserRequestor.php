<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\Client\UserClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class UserRequestor extends AbstractRequestor
{

	/** @var UserClient */
	private $client;

	public function __construct(UserClient $client)
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

}
