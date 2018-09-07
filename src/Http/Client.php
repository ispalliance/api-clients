<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use ISPA\ApiClients\Exception\Runtime\RequestException;
use Psr\Http\Message\ResponseInterface;

interface Client
{

	/**
	 * Parameter options is the Guzzle options!
	 * If change client implementation then we must transform Guzzle options to new client options.
	 * This may be imposibble, then we must search all options usage and change them.
	 * Interface is used primary for caching (CacheClient decorator), testing, logging, etc.
	 *
	 * $testClient = new class implements ClientInterface {
	 *       public function request(string $method, $uri, array $options = []): ResponseInterface
	 *     {
	 *         return new Response(200, [], '{"key": "value"}');
	 *     }
	 * };
	 *
	 * @param mixed[] $options
	 * @throws RequestException
	 */
	public function request(string $method, string $uri, array $options = []): ResponseInterface;

}
