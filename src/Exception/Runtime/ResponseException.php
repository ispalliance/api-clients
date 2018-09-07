<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Exception\Runtime;

use ISPA\ApiClients\Exception\RuntimeException;
use Psr\Http\Message\ResponseInterface;

class ResponseException extends RuntimeException
{

	/** @var ResponseInterface */
	private $response;

	public function __construct(ResponseInterface $response, ?string $message = null)
	{
		if ($message === null) {
			$message = sprintf('Unexpected status code "%d".', $response->getStatusCode());
		}

		parent::__construct($message, 0);
	}

	public function getResponse(): ResponseInterface
	{
		return $this->response;
	}

}
