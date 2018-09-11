<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

abstract class BaseAppPass extends AbstractPass
{

	/** @var mixed[] */
	public $defaults = [
		'guzzle' => [],
	];

	protected function isEnabled(string $name): bool
	{
		$config = $this->extension->getConfig();

		return isset($config['app'][$name]) && $config['app'][$name] !== FALSE;
	}

	/**
	 * @return mixed[]
	 */
	protected function validateConfig(string $name): array
	{
		$config = $this->extension->getConfig();

		return $this->extension->validateConfig($this->defaults, $config['app'][$name]);
	}

}
