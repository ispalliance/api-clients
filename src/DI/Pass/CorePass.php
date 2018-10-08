<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\Domain\ApiProvider;
use ISPA\ApiClients\Http\GuzzleFactory;

class CorePass extends AbstractPass
{

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig();

		$builder->addDefinition($this->extension->prefix('provider'))
			->setFactory(ApiProvider::class);

		$builder->addDefinition($this->extension->prefix('guzzleFactory'))
			->setFactory(GuzzleFactory::class, [$config]);
	}

}
