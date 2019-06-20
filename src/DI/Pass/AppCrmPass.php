<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Adminus\Client\AccountingEntityClient;
use ISPA\ApiClients\App\Adminus\Client\ContractClient;
use ISPA\ApiClients\App\Adminus\Client\CustomerClient;
use ISPA\ApiClients\App\Adminus\Client\UserClient;
use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\UserRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppCrmPass extends BaseAppPass
{

	public const APP_NAME = 'crm';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.adminus.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.adminus.client.accountingEntity'))
			->setFactory(AccountingEntityClient::class, [$this->extension->prefix('@app.adminus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.client.contract'))
			->setFactory(ContractClient::class, [$this->extension->prefix('@app.adminus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.client.customer'))
			->setFactory(CustomerClient::class, [$this->extension->prefix('@app.adminus.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.client.user'))
			->setFactory(UserClient::class, [$this->extension->prefix('@app.adminus.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.adminus.requestor.accountingEntity'))
			->setFactory(AccountingEntityRequestor::class, [$this->extension->prefix('@app.adminus.client.accountingEntity')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.requestor.contract'))
			->setFactory(ContractRequestor::class, [$this->extension->prefix('@app.adminus.client.contract')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.requestor.customer'))
			->setFactory(CustomerRequestor::class, [$this->extension->prefix('@app.adminus.client.customer')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.requestor.user'))
			->setFactory(UserRequestor::class, [$this->extension->prefix('@app.adminus.client.user')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.adminus.rootquestor'))
			->setFactory(CrmRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.adminus.rootquestor'))
			->addSetup('add', ['accountingEntity', $this->extension->prefix('@app.adminus.requestor.accountingEntity')])
			->addSetup('add', ['contract', $this->extension->prefix('@app.adminus.requestor.contract')])
			->addSetup('add', ['customer', $this->extension->prefix('@app.adminus.requestor.customer')])
			->addSetup('add', ['user', $this->extension->prefix('@app.adminus.requestor.user')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.adminus.rootquestor')]);
	}

}
