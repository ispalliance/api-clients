<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Adminus\CrmClient;
use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\UserRequestor;
use Nette\DI\Statement;

class AppCrmPass extends BaseAppPass
{

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled('crm')) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig('crm');

		// Register api client

		$builder->addDefinition($this->extension->prefix('app.crm.client'))
			->setFactory(CrmClient::class, [
				new Statement($this->extension->prefix('@guzzle.appFactory::create'), ['crm']),
			]);

		// Register rootquestor

		$rootquestorDef = $builder->addDefinition($this->extension->prefix('app.crm.rootquestor'))
			->setFactory(CrmRootquestor::class);

		// Register requestors + append them to rootquestor

		$builder->addDefinition($this->extension->prefix('app.crm.requestor.accountingEntity'))
			->setFactory(AccountingEntityRequestor::class);
		$rootquestorDef->addSetup('add', ['accountingEntity', $this->extension->prefix('@app.crm.requestor.accountingEntity')]);

		$builder->addDefinition($this->extension->prefix('app.crm.requestor.contract'))
			->setFactory(ContractRequestor::class);
		$rootquestorDef->addSetup('add', ['contract', $this->extension->prefix('@app.crm.requestor.contract')]);

		$builder->addDefinition($this->extension->prefix('app.crm.requestor.customer'))
			->setFactory(CustomerRequestor::class);
		$rootquestorDef->addSetup('add', ['user', $this->extension->prefix('@app.crm.requestor.customer')]);

		$builder->addDefinition($this->extension->prefix('app.crm.requestor.user'))
			->setFactory(UserRequestor::class);
		$rootquestorDef->addSetup('add', ['user', $this->extension->prefix('@app.crm.requestor.user')]);
	}

}
