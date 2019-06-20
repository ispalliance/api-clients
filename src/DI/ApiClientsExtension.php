<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\DI\Pass\AbstractPass;
use ISPA\ApiClients\DI\Pass\AppAresPass;
use ISPA\ApiClients\DI\Pass\AppCrmPass;
use ISPA\ApiClients\DI\Pass\AppDbdPass;
use ISPA\ApiClients\DI\Pass\AppJuicyPdfPass;
use ISPA\ApiClients\DI\Pass\AppLotusPass;
use ISPA\ApiClients\DI\Pass\AppNominatimPass;
use ISPA\ApiClients\DI\Pass\AppPedefPass;
use ISPA\ApiClients\DI\Pass\AppRuianPass;
use ISPA\ApiClients\DI\Pass\CorePass;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Validators;

class ApiClientsExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => FALSE,
		'app' => [
			'ares' => [],
			'crm' => [],
			'dbd' => [],
			'lotus' => [],
			'juicypdf' => [],
			'nominatim' => [],
			'nms' => [],
			'pedef' => [],
			'ruian' => [],
		],
	];

	/** @var AbstractPass[] */
	private $passes = [];

	/** @var string[] */
	private $map = [
		CorePass::APP_NAME => CorePass::class,
		AppAresPass::APP_NAME => AppAresPass::class,
		AppCrmPass::APP_NAME => AppCrmPass::class,
		AppDbdPass::APP_NAME => AppDbdPass::class,
		AppLotusPass::APP_NAME => AppLotusPass::class,
		AppNominatimPass::APP_NAME => AppNominatimPass::class,
		AppPedefPass::APP_NAME => AppPedefPass::class,
		AppRuianPass::APP_NAME => AppRuianPass::class,
		AppJuicyPdfPass::APP_NAME => AppJuicyPdfPass::class,
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
			if ($passName === CorePass::APP_NAME || !in_array($passConfig, [NULL, FALSE], TRUE)) {
				$this->passes[] = new $passClass($this);
			}
		}

		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->loadPassConfiguration();
		}
	}

	public function beforeCompile(): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->beforePassCompile();
		}
	}

	public function afterCompile(ClassType $class): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->afterPassCompile($class);
		}
	}

}
