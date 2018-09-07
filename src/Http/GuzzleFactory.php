<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use GuzzleHttp\Client;

class GuzzleFactory
{

	/** @var bool */
	private $debug;

	public function __construct(bool $debug)
	{
		$this->debug = $debug;
	}

	/**
	 * @param mixed[] $config
	 */
	public function create(array $config = []): Client
	{
		if ($this->debug) {
			// todo: Tracy middleware
			'fix empty statement';
		}

		return new Client($config);
	}

}
