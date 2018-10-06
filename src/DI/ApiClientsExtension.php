<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\DI\Pass\AbstractPass;
use ISPA\ApiClients\DI\Pass\AppAresPass;
use ISPA\ApiClients\DI\Pass\AppCrmPass;
use ISPA\ApiClients\DI\Pass\AppLotusPass;
use ISPA\ApiClients\DI\Pass\AppPedefPass;
use ISPA\ApiClients\DI\Pass\CorePass;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Utils\Validators;

class ApiClientsExtension extends CompilerExtension
{

	/** @var mixed[] */
	private $defaults = [
		'debug' => FALSE,
		'app'   => [
			'ares'  => [],
			'lotus' => [],
			'crm'   => [],
			'nms'   => [],
			'pedef' => [],
		],
	];

	/** @var AbstractPass[] */
	private $passes = [];

	public function __construct()
	{
		$this->passes[] = new CorePass($this);
		$this->passes[] = new AppAresPass($this);
		$this->passes[] = new AppCrmPass($this);
		$this->passes[] = new AppLotusPass($this);
		$this->passes[] = new AppPedefPass($this);
	}

	public function loadConfiguration(): void
	{
		// Validate config on top level
		$config = $this->validateConfig($this->defaults);

		// Validate right structure of app
		Validators::assertField($config, 'app', 'array');

		// Validate allowed apps
		$this->validateConfig($this->defaults['app'], $config['app']);

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
