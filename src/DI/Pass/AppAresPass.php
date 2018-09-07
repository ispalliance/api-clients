<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use ISPA\ApiClients\DI\AppBuilder;

class AppAresPass extends BaseAppPass
{

	public function loadPassConfiguration(): void
	{
		$app = 'ares';

		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled($app)) return;

		$this->validateConfig($app);

		$config = $this->getConfig($app);

		$builder = new AppBuilder($this->extension);

		// Http client
		$httpClient = $builder->addHttpClient($app);

		// Clients
		$addressClient = $builder->addClient($app, 'address', AddressClient::class, ['@' . $httpClient]);
		$subjectClient = $builder->addClient($app, 'subject', SubjectClient::class, ['@' . $httpClient]);

		// Rootquestor
		$builder->addRootquestor($app, AresRootquestor::class);

		// Requestors
		$builder->addRequestor($app, 'address', AddressRequestor::class, ['@' . $addressClient]);
		$builder->addRequestor($app, 'subject', SubjectRequestor::class, ['@' . $subjectClient]);
	}

}
