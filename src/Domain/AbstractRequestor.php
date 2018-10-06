<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Psr\Http\Message\ResponseInterface;

/**
 * All public methods may throw ResponseException.
 */
abstract class AbstractRequestor
{

	/**
	 * @param int[] $allowedStatusCodes
	 */
	protected function assertResponse(ResponseInterface $response, array $allowedStatusCodes = [200]): void
	{
		if (!in_array($response->getStatusCode(), $allowedStatusCodes, TRUE)) {
			throw new ResponseException($response);
		}
	}

}
