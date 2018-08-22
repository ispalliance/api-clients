<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use GuzzleHttp\Client;

class GuzzleAppFactory
{

	/** @var mixed[] */
	protected $config = [];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function create(string $app): Client
	{
		$config = $this->config[$app]['guzzle'] ?? [];

		return new Client($config);
	}

}
