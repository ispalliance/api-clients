<?php declare(strict_types = 1);

namespace Tests\Cases\DI;

use ISPA\ApiClients\App\Adminus\Crm\Client\AccountingEntityClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\ContractClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\CustomerClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\CustomerFileClient;
use ISPA\ApiClients\App\Adminus\Crm\Client\UserClient;
use ISPA\ApiClients\App\Adminus\Crm\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\CustomerFileRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Crm\Requestor\UserRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Client\AreaClient;
use ISPA\ApiClients\App\Adminus\Nms\Client\DeviceClient;
use ISPA\ApiClients\App\Adminus\Nms\Client\PopClient;
use ISPA\ApiClients\App\Adminus\Nms\NmsRootquestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\AreaRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\DeviceRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\PopRequestor;
use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use ISPA\ApiClients\App\Lotus\Client\CalendarClient;
use ISPA\ApiClients\App\Lotus\Client\PlanClient;
use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Client\SnippetClient;
use ISPA\ApiClients\App\Lotus\Client\UserClient as LotusUserClient;
use ISPA\ApiClients\App\Lotus\Client\UserGroupClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\CalendarRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\PlanRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\SnippetRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserGroupRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor as LotusUserRequestor;
use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\App\Ruian\Client\AddressPlacesClient;
use ISPA\ApiClients\App\Ruian\Client\AutocompleteClient;
use ISPA\ApiClients\App\Ruian\Client\BuildingObjectClient;
use ISPA\ApiClients\App\Ruian\Client\CadastralAreaClient;
use ISPA\ApiClients\App\Ruian\Client\DistrictClient;
use ISPA\ApiClients\App\Ruian\Client\MetaClient;
use ISPA\ApiClients\App\Ruian\Client\MunicipalityClient;
use ISPA\ApiClients\App\Ruian\Client\MunicipalityPartClient;
use ISPA\ApiClients\App\Ruian\Client\ParcelClient;
use ISPA\ApiClients\App\Ruian\Client\RegionClient;
use ISPA\ApiClients\App\Ruian\Client\SearchClient;
use ISPA\ApiClients\App\Ruian\Client\StreetClient;
use ISPA\ApiClients\App\Ruian\Client\ZsjClient;
use ISPA\ApiClients\App\Ruian\Requestor\AddressPlacesRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\AutocompleteRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\BuildingObjectRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\CadastralAreaRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\DistrictRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\MetaRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\MunicipalityPartRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\MunicipalityRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\ParcelRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\RegionRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\SearchRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\StreetRequestor;
use ISPA\ApiClients\App\Ruian\Requestor\ZsjRequestor;
use ISPA\ApiClients\App\Ruian\RuianRootquestor;
use ISPA\ApiClients\DI\ApiClientsExtension;
use ISPA\ApiClients\DI\ApiClientsExtension24;
use ISPA\ApiClients\Domain\ApiProvider;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\Compiler;
use Nette\DI\Definitions\ServiceDefinition;
use Tests\Toolkit\ContainerTestCase;

class ApiClientsExtensionTest extends ContainerTestCase
{

	protected function setUpCompileContainer(Compiler $compiler): void
	{
		$extension = class_exists(ServiceDefinition::class)
            ? new ApiClientsExtension()
            : new ApiClientsExtension24();
		$compiler->addExtension('ispa.apis', $extension);
		$compiler->addConfig([
			'ispa.apis' => [
				'app' => [
					'ares' => [],
					'adminus_crm' => [],
					'adminus_nms' => [],
					'dbd' => [
						'http' => [
							'wsdl' => 'http://ws.dcgroup.cz/index.php?WSDL',
						],
					],
					'lotus' => [],
					'juicypdf' => [],
					'nominatim' => [],
					'pedef' => [],
					'ruian' => [],
				],
			],
		]);
	}

	public function testServicesRegistration(): void
	{
		// CorePass
		static::assertInstanceOf(ApiProvider::class, $this->getContainer()->getService('ispa.apis.provider'));
		static::assertInstanceOf(GuzzleFactory::class, $this->getContainer()->getService('ispa.apis.guzzleFactory'));

		// AppAresPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.ares.http.client'));

		static::assertInstanceOf(AddressClient::class, $this->getContainer()->getService('ispa.apis.app.ares.client.address'));
		static::assertInstanceOf(SubjectClient::class, $this->getContainer()->getService('ispa.apis.app.ares.client.subject'));

		static::assertInstanceOf(AddressRequestor::class, $this->getContainer()->getService('ispa.apis.app.ares.requestor.address'));
		static::assertInstanceOf(SubjectRequestor::class, $this->getContainer()->getService('ispa.apis.app.ares.requestor.subject'));

		static::assertInstanceOf(AresRootquestor::class, $this->getContainer()->getService('ispa.apis.app.ares.rootquestor'));
		static::assertInstanceOf(AddressRequestor::class, $this->getContainer()->getService('ispa.apis.app.ares.rootquestor')->address);
		static::assertInstanceOf(SubjectRequestor::class, $this->getContainer()->getService('ispa.apis.app.ares.rootquestor')->subject);

		static::assertInstanceOf(AresRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->ares);

		// AppAdminusCrmPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.http.client'));

		static::assertInstanceOf(AccountingEntityClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.client.accountingEntity'));
		static::assertInstanceOf(ContractClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.client.contract'));
		static::assertInstanceOf(CustomerClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.client.customer'));
		static::assertInstanceOf(UserClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.client.user'));
		static::assertInstanceOf(CustomerFileClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.client.customerFile'));

		static::assertInstanceOf(AccountingEntityRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.requestor.accountingEntity'));
		static::assertInstanceOf(ContractRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.requestor.contract'));
		static::assertInstanceOf(CustomerRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.requestor.customer'));
		static::assertInstanceOf(UserRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.requestor.user'));
		static::assertInstanceOf(CustomerFileRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.requestor.customerFile'));

		static::assertInstanceOf(CrmRootquestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.rootquestor'));

		static::assertInstanceOf(AccountingEntityRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.rootquestor')->accountingEntity);
		static::assertInstanceOf(ContractRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.rootquestor')->contract);
		static::assertInstanceOf(CustomerRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.rootquestor')->customer);
		static::assertInstanceOf(UserRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.crm.rootquestor')->user);

		static::assertInstanceOf(CrmRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->adminusCrm);

		// AppAdminusNmsPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.http.client'));

		static::assertInstanceOf(AreaClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.client.area'));
		static::assertInstanceOf(DeviceClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.client.device'));
		static::assertInstanceOf(PopClient::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.client.pop'));

		static::assertInstanceOf(AreaRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.requestor.area'));
		static::assertInstanceOf(DeviceRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.requestor.device'));
		static::assertInstanceOf(PopRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.requestor.pop'));

		static::assertInstanceOf(NmsRootquestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.rootquestor'));

		static::assertInstanceOf(AreaRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.rootquestor')->area);
		static::assertInstanceOf(DeviceRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.rootquestor')->device);
		static::assertInstanceOf(PopRequestor::class, $this->getContainer()->getService('ispa.apis.app.adminus.nms.rootquestor')->pop);

		static::assertInstanceOf(NmsRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->adminusNms);

		// AppLotusPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.http.client'));

		static::assertInstanceOf(CalendarClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.calendar'));
		static::assertInstanceOf(PlanClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.plan'));
		static::assertInstanceOf(ProcessClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.process'));
		static::assertInstanceOf(SnippetClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.snippet'));
		static::assertInstanceOf(LotusUserClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.user'));
		static::assertInstanceOf(UserGroupClient::class, $this->getContainer()->getService('ispa.apis.app.lotus.client.userGroup'));

		static::assertInstanceOf(CalendarRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.calendar'));
		static::assertInstanceOf(PlanRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.plan'));
		static::assertInstanceOf(ProcessRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.process'));
		static::assertInstanceOf(SnippetRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.snippet'));
		static::assertInstanceOf(LotusUserRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.user'));
		static::assertInstanceOf(UserGroupRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.requestor.userGroup'));

		static::assertInstanceOf(LotusRootquestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor'));

		static::assertInstanceOf(CalendarRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor')->calendar);
		static::assertInstanceOf(ProcessRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor')->process);
		static::assertInstanceOf(SnippetRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor')->snippet);
		static::assertInstanceOf(LotusUserRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor')->user);
		static::assertInstanceOf(UserGroupRequestor::class, $this->getContainer()->getService('ispa.apis.app.lotus.rootquestor')->userGroup);

		static::assertInstanceOf(LotusRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->lotus);

		// AppPedefPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.pedef.http.client'));

		static::assertInstanceOf(ThumbnailClient::class, $this->getContainer()->getService('ispa.apis.app.pedef.client.thumbnail'));

		static::assertInstanceOf(ThumbnailRequestor::class, $this->getContainer()->getService('ispa.apis.app.pedef.requestor.thumbnail'));

		static::assertInstanceOf(PedefRootquestor::class, $this->getContainer()->getService('ispa.apis.app.pedef.rootquestor'));

		static::assertInstanceOf(ThumbnailRequestor::class, $this->getContainer()->getService('ispa.apis.app.pedef.rootquestor')->thumbnail);

		static::assertInstanceOf(PedefRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->pedef);

		// AppRuianPass
		static::assertInstanceOf(HttpClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.http.client'));

		static::assertInstanceOf(AddressPlacesClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.addressPlaces'));
		static::assertInstanceOf(AutocompleteClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.autocomplete'));
		static::assertInstanceOf(BuildingObjectClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.buildingObject'));
		static::assertInstanceOf(CadastralAreaClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.cadastralArea'));
		static::assertInstanceOf(DistrictClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.district'));
		static::assertInstanceOf(MetaClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.meta'));
		static::assertInstanceOf(MunicipalityClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.municipality'));
		static::assertInstanceOf(MunicipalityPartClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.municipalityPart'));
		static::assertInstanceOf(ParcelClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.parcel'));
		static::assertInstanceOf(RegionClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.region'));
		static::assertInstanceOf(SearchClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.search'));
		static::assertInstanceOf(StreetClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.street'));
		static::assertInstanceOf(ZsjClient::class, $this->getContainer()->getService('ispa.apis.app.ruian.client.zsj'));

		static::assertInstanceOf(AddressPlacesRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.addressPlaces'));
		static::assertInstanceOf(AutocompleteRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.autocomplete'));
		static::assertInstanceOf(BuildingObjectRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.buildingObject'));
		static::assertInstanceOf(CadastralAreaRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.cadastralArea'));
		static::assertInstanceOf(DistrictRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.district'));
		static::assertInstanceOf(MetaRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.meta'));
		static::assertInstanceOf(MunicipalityRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.municipality'));
		static::assertInstanceOf(MunicipalityPartRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.municipalityPart'));
		static::assertInstanceOf(ParcelRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.parcel'));
		static::assertInstanceOf(RegionRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.region'));
		static::assertInstanceOf(SearchRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.search'));
		static::assertInstanceOf(StreetRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.street'));
		static::assertInstanceOf(ZsjRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.requestor.zsj'));

		static::assertInstanceOf(RuianRootquestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor'));

		static::assertInstanceOf(AddressPlacesRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->addressPlaces);
		static::assertInstanceOf(AutocompleteRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->autocomplete);
		static::assertInstanceOf(BuildingObjectRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->buildingObject);
		static::assertInstanceOf(CadastralAreaRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->cadastralArea);
		static::assertInstanceOf(DistrictRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->district);
		static::assertInstanceOf(MetaRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->meta);
		static::assertInstanceOf(MunicipalityRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->municipality);
		static::assertInstanceOf(MunicipalityPartRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->municipalityPart);
		static::assertInstanceOf(ParcelRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->parcel);
		static::assertInstanceOf(RegionRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->region);
		static::assertInstanceOf(SearchRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->search);
		static::assertInstanceOf(StreetRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->street);
		static::assertInstanceOf(ZsjRequestor::class, $this->getContainer()->getService('ispa.apis.app.ruian.rootquestor')->zsj);

		static::assertInstanceOf(RuianRootquestor::class, $this->getContainer()->getService('ispa.apis.provider')->ruian);
	}

}
