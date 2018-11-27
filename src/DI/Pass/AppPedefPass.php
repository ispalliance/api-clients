<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppPedefPass extends BaseAppPass
{

	public const APP_NAME = 'pedef';

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled(self::APP_NAME)) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

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
		$builder->addDefinition($this->extension->prefix('app.pedef.rootquestor'))
			->setFactory(PedefRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.pedef.rootquestor'))
			->addSetup('add', ['thumbnail', $this->extension->prefix('@app.pedef.requestor.thumbnail')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.pedef.rootquestor')]);
	}

}
