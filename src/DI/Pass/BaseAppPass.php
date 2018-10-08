<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

abstract class BaseAppPass extends AbstractPass
{

	/** @var mixed[] */
	protected $defaults = [
		'http' => [],
	];

	protected function isEnabled(string $app): bool
	{
		$config = $this->extension->getConfig();

		return isset($config['app'][$app]) && $config['app'][$app] !== FALSE;
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
