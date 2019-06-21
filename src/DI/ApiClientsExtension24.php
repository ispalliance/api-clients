<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\DI\Pass\AbstractPass;
use ISPA\ApiClients\DI\Pass\CorePass;
use Nette\Utils\Validators;

class ApiClientsExtension24 extends ApiClientsExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => FALSE,
		'app' => [
			'ares' => NULL,
			'crm' => NULL,
			'dbd' => NULL,
			'lotus' => NULL,
			'juicypdf' => NULL,
			'nominatim' => NULL,
			'nms' => NULL,
			'pedef' => NULL,
			'ruian' => NULL,
		],
	];

	public function loadConfiguration(): void
	{
		// Validate config on top level
		$config = $this->validateConfig($this->defaults);

		// Validate right structure of app
		Validators::assertField($config, 'app', 'array');

		// Validate allowed apps
		$this->validateConfig($this->defaults['app'], $config['app']);

		// Instantiate enabled passes
		foreach ($this->map as $passName => $passClass) {
			$passConfig = $config['app'][$passName] ?? NULL;
			if ($passConfig !== NULL) {
				/** @var AbstractPass $pass */
				$this->passes[] = $pass = new $passClass($this);
				$pass->setConfig($passConfig);
			}
		}

		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->loadPassConfiguration();
		}
	}

}
