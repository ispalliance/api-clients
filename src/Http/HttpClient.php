<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use ISPA\ApiClients\Exception\Runtime\RequestException;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{

	/**
	 * @param mixed[] $options
	 * @throws RequestException
	 */
	public function request(string $method, string $uri, array $options = []): ResponseInterface;

}
