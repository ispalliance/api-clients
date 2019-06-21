<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Dbd\Client\DebtorClient;
use ISPA\ApiClients\App\Dbd\DbdRootquestor;
use ISPA\ApiClients\App\Dbd\Requestor\DebtorRequestor;
use ISPA\ApiClients\Http\SoapClient;
use Nette\DI\ServiceDefinition;

class AppDbdPass extends BaseAppPass
{

	public const APP_NAME = 'dbd';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->config;

		// #1 SOAP client
		$builder->addDefinition($this->extension->prefix('app.dbd.soap.client'))
			->setFactory($this->extension->prefix('@soapFactory::create'), [self::APP_NAME])
			->setType(SoapClient::class)
			->setAutowired(FALSE);

		// #2 Client
		$builder->addDefinition($this->extension->prefix('app.dbd.client.debtor'))
			->setFactory(DebtorClient::class, [$this->extension->prefix('@app.dbd.soap.client'), $config]);

		// #3 Requestor
		$builder->addDefinition($this->extension->prefix('app.dbd.requestor.debtor'))
			->setFactory(DebtorRequestor::class, [$this->extension->prefix('@app.dbd.client.debtor')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.dbd.rootquestor'))
			->setFactory(DbdRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['debtor', $this->extension->prefix('@app.dbd.requestor.debtor')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.dbd.rootquestor')]);
	}

}
