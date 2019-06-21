<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\ServiceDefinition;

class AppAresPass extends BaseAppPass
{

	public const APP_NAME = 'ares';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.ares.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.ares.client.address'))
			->setFactory(AddressClient::class, [$this->extension->prefix('@app.ares.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ares.client.subject'))
			->setFactory(SubjectClient::class, [$this->extension->prefix('@app.ares.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.ares.requestor.address'))
			->setFactory(AddressRequestor::class, [$this->extension->prefix('@app.ares.client.address')]);
		$builder->addDefinition($this->extension->prefix('app.ares.requestor.subject'))
			->setFactory(SubjectRequestor::class, [$this->extension->prefix('@app.ares.client.subject')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.ares.rootquestor'))
			->setFactory(AresRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['address', $this->extension->prefix('@app.ares.requestor.address')])
			->addSetup('add', ['subject', $this->extension->prefix('@app.ares.requestor.subject')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.ares.rootquestor')]);
	}

}
