<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\CPost\Client\ConsignmentClient;
use ISPA\ApiClients\App\CPost\CpostRootquestor;
use ISPA\ApiClients\App\CPost\Requestor\ConsignmentRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppCPostPass extends BaseAppPass
{

	private const APP_NAME = 'cpost';

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled(self::APP_NAME)) return;

		$builder = $this->extension->getContainerBuilder();
		$config = $this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.cpost.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.cpost.client.consignment'))
			->setFactory(ConsignmentClient::class, [$this->extension->prefix('@app.cpost.http.client'), $config]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.cpost.requestor.consignment'))
			->setFactory(ConsignmentRequestor::class, [$this->extension->prefix('@app.cpost.client.consignment')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.cpost.rootquestor'))
			->setFactory(CpostRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.cpost.rootquestor'))
			->addSetup('add', ['consignment', $this->extension->prefix('@app.cpost.requestor.consignment')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.cpost.rootquestor')]);
	}

}
