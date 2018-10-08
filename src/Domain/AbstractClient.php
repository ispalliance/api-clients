<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\Http\HttpClient;

/**
 * All public methods must return ResponseInterface
 */
abstract class AbstractClient
{

	/** @var HttpClient */
	protected $httpClient;

	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

}
