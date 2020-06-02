<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\DI\Pass\AbstractPass;
use ISPA\ApiClients\DI\Pass\AppAdminusCrmPass;
use ISPA\ApiClients\DI\Pass\AppAdminusNmsPass;
use ISPA\ApiClients\DI\Pass\AppAresPass;
use ISPA\ApiClients\DI\Pass\AppDbdPass;
use ISPA\ApiClients\DI\Pass\AppJuicyPdfPass;
use ISPA\ApiClients\DI\Pass\AppNominatimPass;
use ISPA\ApiClients\DI\Pass\AppPedefPass;
use ISPA\ApiClients\DI\Pass\AppRuianPass;
use ISPA\ApiClients\DI\Pass\CorePass;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @method mixed[] getConfig()
 * @property-read mixed[] $config
 */
class ApiClientsExtension extends CompilerExtension
{

	/** @var AbstractPass[] */
	protected $passes = [];

	/** @var string[] */
	protected $map = [
		AppAresPass::APP_NAME => AppAresPass::class,
		AppAdminusCrmPass::APP_NAME => AppAdminusCrmPass::class,
		AppAdminusNmsPass::APP_NAME => AppAdminusNmsPass::class,
		AppDbdPass::APP_NAME => AppDbdPass::class,
		AppJuicyPdfPass::APP_NAME => AppJuicyPdfPass::class,
		AppNominatimPass::APP_NAME => AppNominatimPass::class,
		AppPedefPass::APP_NAME => AppPedefPass::class,
		AppRuianPass::APP_NAME => AppRuianPass::class,
	];

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'debug' => Expect::bool(FALSE),
			'app' => Expect::structure([
				AppAresPass::APP_NAME => Expect::anyOf(NULL, AppAresPass::getConfigSchema()),
				AppAdminusCrmPass::APP_NAME => Expect::anyOf(NULL, AppAdminusCrmPass::getConfigSchema()),
				AppAdminusNmsPass::APP_NAME => Expect::anyOf(NULL, AppAdminusNmsPass::getConfigSchema()),
				AppDbdPass::APP_NAME => Expect::anyOf(NULL, AppDbdPass::getConfigSchema()),
				AppJuicyPdfPass::APP_NAME => Expect::anyOf(NULL, AppJuicyPdfPass::getConfigSchema()),
				AppNominatimPass::APP_NAME => Expect::anyOf(NULL, AppNominatimPass::getConfigSchema()),
				AppPedefPass::APP_NAME => Expect::anyOf(NULL, AppPedefPass::getConfigSchema()),
				AppRuianPass::APP_NAME => Expect::anyOf(NULL, AppRuianPass::getConfigSchema()),
			])->castTo('array'),
		])->castTo('array');
	}

	public function __construct()
	{
		$this->passes[] = new CorePass($this);
	}

	public function loadConfiguration(): void
	{
		$config = $this->config;

		// Instantiate and configure enabled passes
		foreach ($this->map as $passName => $passClass) {
			$passConfig = $config['app'][$passName];
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
