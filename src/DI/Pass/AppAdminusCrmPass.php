<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Adminus\Crm\Client\AccountingEntityClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\ContractClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\CustomerClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\UserClient;
use ISPA\ApiClients\App\Adminus\Crm\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\UserRequestor;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\ServiceDefinition;

class AppAdminusCrmPass extends BaseAppPass
{

	public const APP_NAME = 'adminusCrm';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.client.accountingEntity'))
			->setFactory(AccountingEntityClient::class, [$this->extension->prefix('@app.adminus.crm.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.client.contract'))
			->setFactory(ContractClient::class, [$this->extension->prefix('@app.adminus.crm.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.client.customer'))
			->setFactory(CustomerClient::class, [$this->extension->prefix('@app.adminus.crm.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.client.user'))
			->setFactory(UserClient::class, [$this->extension->prefix('@app.adminus.crm.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.requestor.accountingEntity'))
			->setFactory(AccountingEntityRequestor::class, [$this->extension->prefix('@app.adminus.crm.client.accountingEntity')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.requestor.contract'))
			->setFactory(ContractRequestor::class, [$this->extension->prefix('@app.adminus.crm.client.contract')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.requestor.customer'))
			->setFactory(CustomerRequestor::class, [$this->extension->prefix('@app.adminus.crm.client.customer')]);
		$builder->addDefinition($this->extension->prefix('app.adminus.crm.requestor.user'))
			->setFactory(UserRequestor::class, [$this->extension->prefix('@app.adminus.crm.client.user')]);

		// #4 Rootquestor
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.adminus.crm.rootquestor'))
			->setFactory(CrmRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['accountingEntity', $this->extension->prefix('@app.adminus.crm.requestor.accountingEntity')])
			->addSetup('add', ['contract', $this->extension->prefix('@app.adminus.crm.requestor.contract')])
			->addSetup('add', ['customer', $this->extension->prefix('@app.adminus.crm.requestor.customer')])
			->addSetup('add', ['user', $this->extension->prefix('@app.adminus.crm.requestor.user')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.adminus.crm.rootquestor')]);
	}

}
