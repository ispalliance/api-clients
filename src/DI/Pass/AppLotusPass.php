<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Lotus\Client\CalendarClient;
use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Client\SnippetClient;
use ISPA\ApiClients\App\Lotus\Client\UserClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\CalendarRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\SnippetRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppLotusPass extends BaseAppPass
{

	public const APP_NAME = 'lotus';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.lotus.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.lotus.client.calendar'))
			->setFactory(CalendarClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.process'))
			->setFactory(ProcessClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.snippet'))
			->setFactory(SnippetClient::class, [$this->extension->prefix('@app.lotus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.client.user'))
			->setFactory(UserClient::class, [$this->extension->prefix('@app.lotus.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.calendar'))
			->setFactory(CalendarRequestor::class, [$this->extension->prefix('@app.lotus.client.calendar')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.process'))
			->setFactory(ProcessRequestor::class, [$this->extension->prefix('@app.lotus.client.process')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.snippet'))
			->setFactory(SnippetRequestor::class, [$this->extension->prefix('@app.lotus.client.snippet')]);
		$builder->addDefinition($this->extension->prefix('app.lotus.requestor.user'))
			->setFactory(UserRequestor::class, [$this->extension->prefix('@app.lotus.client.user')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->setFactory(LotusRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->addSetup('add', ['calendar', $this->extension->prefix('@app.lotus.requestor.calendar')])
			->addSetup('add', ['process', $this->extension->prefix('@app.lotus.requestor.process')])
			->addSetup('add', ['snippet', $this->extension->prefix('@app.lotus.requestor.snippet')])
			->addSetup('add', ['user', $this->extension->prefix('@app.lotus.requestor.user')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.lotus.rootquestor')]);
	}

}
