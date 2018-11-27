<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http\Soaper;

use InvalidArgumentException;
use SoapClient;

class SoaperFactory
{

	/** @var mixed[] */
	protected $config = [];

	/** @var mixed[] */
	protected $defaults = [
		'http' => [
			'wsdl' => NULL,
			'auth' => [
				'user' => '',
				'pass' => '',
			],
		],
	];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function create(string $app): SoaperClient
	{
		$config = $this->config['app'][$app] ?? [];
		$config = array_merge($this->defaults, $config);

		if ($config['http']['wsdl'] === NULL) {
			throw new InvalidArgumentException('Valid WSDL url address must be specified for SOAP client');
		}

		return new SoaperClient(new SoapClient($config['http']['wsdl']));
	}

}
