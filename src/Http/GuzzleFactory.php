<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use GuzzleHttp\Client;

class GuzzleFactory
{

	/** @var mixed[] */
	protected $config = [];

	/** @var mixed[] */
	protected $defaults = [
		'http_errors' => FALSE, // Disable throwing exceptions on an HTTP protocol errors (i.e., 4xx and 5xx responses)
	];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function create(string $app): GuzzleClient
	{
		// @todo $this->config['debug'] ==> Tracy panel

		$config = $this->config[$app]['http'] ?? [];
		$config = array_merge($this->defaults, $config);

		return new GuzzleClient(new Client($config));
	}

}
