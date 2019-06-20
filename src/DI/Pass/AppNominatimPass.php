<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Nominatim\Client\AddressClient;
use ISPA\ApiClients\App\Nominatim\NominatimRootquestor;
use ISPA\ApiClients\App\Nominatim\Requestor\AddressRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppNominatimPass extends BaseAppPass
{

	public const APP_NAME = 'nominatim';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.nominatim.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.nominatim.client.address'))
			->setFactory(AddressClient::class, [$this->extension->prefix('@app.nominatim.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.nominatim.requestor.address'))
			->setFactory(AddressRequestor::class, [$this->extension->prefix('@app.nominatim.client.address')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.nominatim.rootquestor'))
			->setFactory(NominatimRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.nominatim.rootquestor'))
			->addSetup('add', ['address', $this->extension->prefix('@app.nominatim.requestor.address')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.nominatim.rootquestor')]);
	}

}
