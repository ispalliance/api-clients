<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

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
use ISPA\ApiClients\Http\HttpClient;

class AppRuianPass extends BaseAppPass
{

	public const APP_NAME = 'ruian';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.ruian.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.ruian.client.addressPlaces'))
			->setFactory(AddressPlacesClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.autocomplete'))
			->setFactory(AutocompleteClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.buildingObject'))
			->setFactory(BuildingObjectClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.cadastralArea'))
			->setFactory(CadastralAreaClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.district'))
			->setFactory(DistrictClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.meta'))
			->setFactory(MetaClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.municipality'))
			->setFactory(MunicipalityClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.municipalityPart'))
			->setFactory(MunicipalityPartClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.parcel'))
			->setFactory(ParcelClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.region'))
			->setFactory(RegionClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.search'))
			->setFactory(SearchClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.street'))
			->setFactory(StreetClient::class, [$this->extension->prefix('@app.ruian.http.client')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.client.zsj'))
			->setFactory(ZsjClient::class, [$this->extension->prefix('@app.ruian.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.addressPlaces'))
			->setFactory(AddressPlacesRequestor::class, [$this->extension->prefix('@app.ruian.client.addressPlaces')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.autocomplete'))
			->setFactory(AutocompleteRequestor::class, [$this->extension->prefix('@app.ruian.client.autocomplete')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.buildingObject'))
			->setFactory(BuildingObjectRequestor::class, [$this->extension->prefix('@app.ruian.client.buildingObject')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.cadastralArea'))
			->setFactory(CadastralAreaRequestor::class, [$this->extension->prefix('@app.ruian.client.cadastralArea')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.district'))
			->setFactory(DistrictRequestor::class, [$this->extension->prefix('@app.ruian.client.district')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.meta'))
			->setFactory(MetaRequestor::class, [$this->extension->prefix('@app.ruian.client.meta')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.municipality'))
			->setFactory(MunicipalityRequestor::class, [$this->extension->prefix('@app.ruian.client.municipality')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.municipalityPart'))
			->setFactory(MunicipalityPartRequestor::class, [$this->extension->prefix('@app.ruian.client.municipalityPart')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.parcel'))
			->setFactory(ParcelRequestor::class, [$this->extension->prefix('@app.ruian.client.parcel')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.region'))
			->setFactory(RegionRequestor::class, [$this->extension->prefix('@app.ruian.client.region')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.search'))
			->setFactory(SearchRequestor::class, [$this->extension->prefix('@app.ruian.client.search')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.street'))
			->setFactory(StreetRequestor::class, [$this->extension->prefix('@app.ruian.client.street')]);
		$builder->addDefinition($this->extension->prefix('app.ruian.requestor.zsj'))
			->setFactory(ZsjRequestor::class, [$this->extension->prefix('@app.ruian.client.zsj')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.ruian.rootquestor'))
			->setFactory(RuianRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.ruian.rootquestor'))
			->addSetup('add', ['addressPlaces', $this->extension->prefix('@app.ruian.requestor.addressPlaces')])
			->addSetup('add', ['autocomplete', $this->extension->prefix('@app.ruian.requestor.autocomplete')])
			->addSetup('add', ['buildingObject', $this->extension->prefix('@app.ruian.requestor.buildingObject')])
			->addSetup('add', ['cadastralArea', $this->extension->prefix('@app.ruian.requestor.cadastralArea')])
			->addSetup('add', ['district', $this->extension->prefix('@app.ruian.requestor.district')])
			->addSetup('add', ['meta', $this->extension->prefix('@app.ruian.requestor.meta')])
			->addSetup('add', ['municipality', $this->extension->prefix('@app.ruian.requestor.municipality')])
			->addSetup('add', ['municipalityPart', $this->extension->prefix('@app.ruian.requestor.municipalityPart')])
			->addSetup('add', ['parcel', $this->extension->prefix('@app.ruian.requestor.parcel')])
			->addSetup('add', ['region', $this->extension->prefix('@app.ruian.requestor.region')])
			->addSetup('add', ['search', $this->extension->prefix('@app.ruian.requestor.search')])
			->addSetup('add', ['street', $this->extension->prefix('@app.ruian.requestor.street')])
			->addSetup('add', ['zsj', $this->extension->prefix('@app.ruian.requestor.zsj')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.ruian.rootquestor')]);
	}

}
