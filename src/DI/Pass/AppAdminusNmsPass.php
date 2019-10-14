<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Adminus\Nms\Client\AreaClient;
use ISPA\ApiClients\App\Adminus\Nms\Client\DeviceClient;
use ISPA\ApiClients\App\Adminus\Nms\Client\PopClient;
use ISPA\ApiClients\App\Adminus\Nms\NmsRootquestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\AreaRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\DeviceRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\PopRequestor;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\ServiceDefinition;

class AppAdminusNmsPass extends BaseAppPass
{

	public const APP_NAME = 'adminusNms';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.client.area'))
			->setFactory(AreaClient::class, [$this->extension->prefix('@app.adminus.nms.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.client.device'))
			->setFactory(DeviceClient::class, [$this->extension->prefix('@app.adminus.nms.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.client.pop'))
			->setFactory(PopClient::class, [$this->extension->prefix('@app.adminus.nms.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.requestor.area'))
			->setFactory(AreaRequestor::class, [$this->extension->prefix('@app.adminus.nms.client.area')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.requestor.device'))
			->setFactory(DeviceRequestor::class, [$this->extension->prefix('@app.adminus.nms.client.device')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.nms.requestor.pop'))
			->setFactory(PopRequestor::class, [$this->extension->prefix('@app.adminus.nms.client.pop')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.adminus.nms.rootquestor'))
			->setFactory(NmsRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['area', $this->extension->prefix('@app.adminus.nms.requestor.area')])
			->addSetup('add', ['device', $this->extension->prefix('@app.adminus.nms.requestor.device')])
			->addSetup('add', ['pop', $this->extension->prefix('@app.adminus.nms.requestor.pop')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.adminus.nms.rootquestor')]);
	}

}
