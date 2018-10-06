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
use ISPA\ApiClients\DI\AppBuilder;

class AppCrmPass extends BaseAppPass
{

	/** @var mixed[] */
	protected $defaults = [
		'http' => [
			'baseUri' => '',
		],
	];

	public function loadPassConfiguration(): void
	{
		$app = 'crm';

		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled($app)) return;

		$this->validateConfig($app);

		$config = $this->getConfig($app);

		$builder = new AppBuilder($this->extension);

		// Http client
		$httpClient = $builder->addHttpClient($app, [
			'base_uri' => $config['http']['baseUri'],
		]);

		// Clients
		$accountingEntityClient = $builder->addClient($app, 'accountingEntity', AccountingEntityClient::class, ['@' . $httpClient]);
		$contractClient         = $builder->addClient($app, 'contract', ContractClient::class, ['@' . $httpClient]);
		$customerClient         = $builder->addClient($app, 'customer', CustomerClient::class, ['@' . $httpClient]);
		$userClient             = $builder->addClient($app, 'user', UserClient::class, ['@' . $httpClient]);

		// Rootquestor
		$builder->addRootquestor($app, CrmRootquestor::class);

		// Requestors
		$builder->addRequestor($app, 'accountingEntity', AccountingEntityRequestor::class, ['@' . $accountingEntityClient]);
		$builder->addRequestor($app, 'contract', ContractRequestor::class, ['@' . $contractClient]);
		$builder->addRequestor($app, 'customer', CustomerRequestor::class, ['@' . $customerClient]);
		$builder->addRequestor($app, 'user', UserRequestor::class, ['@' . $userClient]);
	}

}
