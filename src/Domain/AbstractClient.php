<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\Http\Client;

/**
 * All public methods must return ResponseInterface
 */
abstract class AbstractClient
{

	/** @var Client */
	protected $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

}
