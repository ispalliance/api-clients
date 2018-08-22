<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Lotus\LotusClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use Nette\DI\Statement;

class AppLotusPass extends BaseAppPass
{

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled('lotus')) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig('lotus');

		// Register api client

		$builder->addDefinition($this->extension->prefix('app.lotus.client'))
			->setFactory(LotusClient::class, [
				new Statement($this->extension->prefix('@guzzle.appFactory::create'), ['lotus']),
			]);

		// Register rootquestor

		$rootquestorDef = $builder->addDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->setFactory(LotusRootquestor::class);

		// Register single requestor + append it to rootquestor

		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.users'))
			->setFactory(UsersRequestor::class);
		$rootquestorDef->addSetup('add', ['users', $this->extension->prefix('@app.lotus.requestor.users')]);
	}

}
