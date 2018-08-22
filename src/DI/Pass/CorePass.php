<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\Domain\ApiClientLocator;
use ISPA\ApiClients\Domain\ApiManager;
use ISPA\ApiClients\Http\GuzzleAppFactory;

class CorePass extends AbstractPass
{

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig();

		$builder->addDefinition($this->extension->prefix('client.locator'))
			->setFactory(ApiClientLocator::class);

		$builder->addDefinition($this->extension->prefix('manager'))
			->setFactory(ApiManager::class);

		$builder->addDefinition($this->extension->prefix('guzzle.appFactory'))
			->setFactory(GuzzleAppFactory::class, [$config['app']]);
	}

}
