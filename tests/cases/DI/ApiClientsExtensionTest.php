<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use ISPA\ApiClients\App\Adminus\Client\AccountingEntityClient;
use ISPA\ApiClients\App\Adminus\Client\ContractClient;
use ISPA\ApiClients\App\Adminus\Client\CustomerClient;
use ISPA\ApiClients\App\Adminus\Client\UserClient;
use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\UserRequestor;
use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use ISPA\ApiClients\App\Lotus\Client\UsersClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\DI\ApiClientsExtension;
use ISPA\ApiClients\Domain\ApiProvider;
use ISPA\ApiClients\Http\GuzzleFactory;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\Compiler;
use Tests\Toolkit\ContainerTestCase;

class ApiClientsExtensionTest extends ContainerTestCase
{

	protected function setUpCompileContainer(Compiler $compiler): void
	{
		$compiler->addExtension('ispa.apis', new ApiClientsExtension());
	}

	public function testServicesRegistration(): void
	{
		// CorePass
		static::assertInstanceOf(ApiProvider::class, $this->container->getService('ispa.apis.provider'));
		static::assertInstanceOf(GuzzleFactory::class, $this->container->getService('ispa.apis.guzzleFactory'));

		// AppAresPass
		static::assertInstanceOf(HttpClient::class, $this->container->getService('ispa.apis.app.ares.http.client'));

		static::assertInstanceOf(AddressClient::class, $this->container->getService('ispa.apis.app.ares.client.address'));
		static::assertInstanceOf(SubjectClient::class, $this->container->getService('ispa.apis.app.ares.client.subject'));

		static::assertInstanceOf(AddressRequestor::class, $this->container->getService('ispa.apis.app.ares.requestor.address'));
		static::assertInstanceOf(SubjectRequestor::class, $this->container->getService('ispa.apis.app.ares.requestor.subject'));

		static::assertInstanceOf(AresRootquestor::class, $this->container->getService('ispa.apis.app.ares.rootquestor'));
		static::assertInstanceOf(AddressRequestor::class, $this->container->getService('ispa.apis.app.ares.rootquestor')->address);
		static::assertInstanceOf(SubjectRequestor::class, $this->container->getService('ispa.apis.app.ares.rootquestor')->subject);

		static::assertInstanceOf(AresRootquestor::class, $this->container->getService('ispa.apis.provider')->ares);

		// AppCrmPass
		static::assertInstanceOf(HttpClient::class, $this->container->getService('ispa.apis.app.adminus.http.client'));

		static::assertInstanceOf(AccountingEntityClient::class, $this->container->getService('ispa.apis.app.adminus.client.accountingEntity'));
		static::assertInstanceOf(ContractClient::class, $this->container->getService('ispa.apis.app.adminus.client.contract'));
		static::assertInstanceOf(CustomerClient::class, $this->container->getService('ispa.apis.app.adminus.client.customer'));
		static::assertInstanceOf(UserClient::class, $this->container->getService('ispa.apis.app.adminus.client.user'));

		static::assertInstanceOf(AccountingEntityRequestor::class, $this->container->getService('ispa.apis.app.adminus.requestor.accountingEntity'));
		static::assertInstanceOf(ContractRequestor::class, $this->container->getService('ispa.apis.app.adminus.requestor.contract'));
		static::assertInstanceOf(CustomerRequestor::class, $this->container->getService('ispa.apis.app.adminus.requestor.customer'));
		static::assertInstanceOf(UserRequestor::class, $this->container->getService('ispa.apis.app.adminus.requestor.user'));

		static::assertInstanceOf(CrmRootquestor::class, $this->container->getService('ispa.apis.app.adminus.rootquestor'));

		static::assertInstanceOf(AccountingEntityRequestor::class, $this->container->getService('ispa.apis.app.adminus.rootquestor')->accountingEntity);
		static::assertInstanceOf(ContractRequestor::class, $this->container->getService('ispa.apis.app.adminus.rootquestor')->contract);
		static::assertInstanceOf(CustomerRequestor::class, $this->container->getService('ispa.apis.app.adminus.rootquestor')->customer);
		static::assertInstanceOf(UserRequestor::class, $this->container->getService('ispa.apis.app.adminus.rootquestor')->user);

		static::assertInstanceOf(CrmRootquestor::class, $this->container->getService('ispa.apis.provider')->crm);

		// AppLotusPass
		static::assertInstanceOf(HttpClient::class, $this->container->getService('ispa.apis.app.lotus.http.client'));

		static::assertInstanceOf(UsersClient::class, $this->container->getService('ispa.apis.app.lotus.client.users'));

		static::assertInstanceOf(UsersRequestor::class, $this->container->getService('ispa.apis.app.lotus.requestor.users'));

		static::assertInstanceOf(LotusRootquestor::class, $this->container->getService('ispa.apis.app.lotus.rootquestor'));

		static::assertInstanceOf(UsersRequestor::class, $this->container->getService('ispa.apis.app.lotus.rootquestor')->users);

		static::assertInstanceOf(LotusRootquestor::class, $this->container->getService('ispa.apis.provider')->lotus);

		// AppPedefPass
		static::assertInstanceOf(HttpClient::class, $this->container->getService('ispa.apis.app.pedef.http.client'));

		static::assertInstanceOf(ThumbnailClient::class, $this->container->getService('ispa.apis.app.pedef.client.thumbnail'));

		static::assertInstanceOf(ThumbnailRequestor::class, $this->container->getService('ispa.apis.app.pedef.requestor.thumbnail'));

		static::assertInstanceOf(PedefRootquestor::class, $this->container->getService('ispa.apis.app.pedef.rootquestor'));

		static::assertInstanceOf(ThumbnailRequestor::class, $this->container->getService('ispa.apis.app.pedef.rootquestor')->thumbnail);

		static::assertInstanceOf(PedefRootquestor::class, $this->container->getService('ispa.apis.provider')->pedef);
	}

}
