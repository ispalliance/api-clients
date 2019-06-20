<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

abstract class BaseAppPass extends AbstractPass
{

	/** @var mixed[] */
	protected $defaults = [
		'http' => [],
		'config' => [],
	];

	/**
	 * @return mixed[]
	 */
	protected function validateConfig(string $name): array
	{
		$config = $this->extension->getConfig();

		return $this->extension->validateConfig($this->defaults, $config['app'][$name]);
	}

}
