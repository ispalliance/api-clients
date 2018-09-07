<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

abstract class BaseAppPass extends AbstractPass
{

	/** @var mixed[] */
	protected $defaults = [];

	protected function isEnabled(string $app): bool
	{
		$config = $this->extension->getConfig();

		return isset($config['app'][$app]);
	}

	protected function validateConfig(string $app): void
	{
		$config = $this->extension->getConfig();

		$this->validateConfigValues($this->defaults, $config['app'][$app]);
	}

	/**
	 * @param mixed[] $defaults
	 * @param mixed[] $config
	 */
	private function validateConfigValues(array $defaults, array $config): void
	{
		// todo: Wrong path if error
		$this->extension->validateConfig($defaults, $config);

		foreach ($defaults as $key => $value) {
			if (is_array($value) && isset($config[$key])) {
				$this->validateConfigValues($value, $config[$key]);
			}
		}
	}

	/**
	 * @return mixed[]
	 */
	protected function getConfig(string $app): array
	{
		return $this->extension->getConfig()['app'][$app];
	}

}
