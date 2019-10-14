<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\DI\Pass\AbstractPass;
use ISPA\ApiClients\DI\Pass\AppAdminusCrmPass;
use ISPA\ApiClients\DI\Pass\AppAresPass;
use ISPA\ApiClients\DI\Pass\AppDbdPass;
use ISPA\ApiClients\DI\Pass\AppJuicyPdfPass;
use ISPA\ApiClients\DI\Pass\AppLotusPass;
use ISPA\ApiClients\DI\Pass\AppNominatimPass;
use ISPA\ApiClients\DI\Pass\AppPedefPass;
use ISPA\ApiClients\DI\Pass\AppRuianPass;
use Nette\Utils\Validators;

class ApiClientsExtension24 extends ApiClientsExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => FALSE,
		'app' => [
			AppAresPass::APP_NAME => NULL,
			AppAdminusCrmPass::APP_NAME => NULL,
			AppDbdPass::APP_NAME => NULL,
			AppLotusPass::APP_NAME => NULL,
			AppJuicyPdfPass::APP_NAME => NULL,
			AppNominatimPass::APP_NAME => NULL,
			AppPedefPass::APP_NAME => NULL,
			AppRuianPass::APP_NAME => NULL,
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
