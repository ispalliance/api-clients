<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Client\UserClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppLotusPass extends BaseAppPass
{

	public const APP_NAME = 'lotus';

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled(self::APP_NAME)) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.lotus.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.lotus.client.user'))
			->setFactory(UserClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.process'))
			->setFactory(ProcessClient::class, [$this->extension->prefix('@app.lotus.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.user'))
			->setFactory(UserRequestor::class, [$this->extension->prefix('@app.lotus.client.user')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.process'))
			->setFactory(ProcessRequestor::class, [$this->extension->prefix('@app.lotus.client.process')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->setFactory(LotusRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->addSetup('add', ['user', $this->extension->prefix('@app.lotus.requestor.user')])
			->addSetup('add', ['process', $this->extension->prefix('@app.lotus.requestor.process')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.lotus.rootquestor')]);
	}

}
