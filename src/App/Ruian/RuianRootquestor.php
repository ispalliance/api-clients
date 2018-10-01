<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian;

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
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read AddressPlacesRequestor $addressPlaces
 * @property-read AutocompleteRequestor $autocomplete
 * @property-read BuildingObjectRequestor $buildingObject
 * @property-read CadastralAreaRequestor $cadastractArea
 * @property-read DistrictRequestor $district
 * @property-read MetaRequestor $meta
 * @property-read MunicipalityRequestor $municipality
 * @property-read MunicipalityPartRequestor $municipalityPart
 * @property-read ParcelRequestor $parcel
 * @property-read RegionRequestor $region
 * @property-read SearchRequestor $search
 * @property-read StreetRequestor $street
 * @property-read ZsjRequestor $zsj
 */
class RuianRootquestor extends AbstractRootquestor
{

}
