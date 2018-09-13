<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Pedef\PedefClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use Nette\DI\Statement;

class AppPedefPass extends BaseAppPass
{

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled('pedef')) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig('pedef');

		// Register api client

		$clientDef = $builder->addDefinition($this->extension->prefix('app.pedef.client'))
			->setFactory(PedefClient::class, [
				new Statement($this->extension->prefix('@guzzle.appFactory::create'), ['pedef']),
			]);

		$builder->getDefinition($this->extension->prefix('client.locator'))
			->addSetup('add', ['pedef', $clientDef]);

		// Register rootquestor

		$rootquestorDef = $builder->addDefinition($this->extension->prefix('app.pedef.rootquestor'))
			->setFactory(PedefRootquestor::class);

		$builder->getDefinition($this->extension->prefix('manager'))
			->addSetup('add', ['pedef', $rootquestorDef]);

		// Register single requestor + append it to rootquestor

		$builder->addDefinition($this->extension->prefix('app.pedef.requestor.thumbnail'))
			->setFactory(ThumbnailRequestor::class);
		$rootquestorDef->addSetup('add', ['thumbnail', $this->extension->prefix('@app.pedef.requestor.thumbnail')]);
	}

}
