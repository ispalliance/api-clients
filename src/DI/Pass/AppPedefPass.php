<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\ServiceDefinition;

class AppPedefPass extends BaseAppPass
{

	public const APP_NAME = 'pedef';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.pedef.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.pedef.client.thumbnail'))
			->setFactory(ThumbnailClient::class, [$this->extension->prefix('@app.pedef.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.pedef.requestor.thumbnail'))
			->setFactory(ThumbnailRequestor::class, [$this->extension->prefix('@app.pedef.client.thumbnail')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.pedef.rootquestor'))
			->setFactory(PedefRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['thumbnail', $this->extension->prefix('@app.pedef.requestor.thumbnail')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.pedef.rootquestor')]);
	}

}
