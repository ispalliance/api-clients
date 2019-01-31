<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim;

use ISPA\ApiClients\App\Nominatim\Requestor\AddressRequestor;
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read AddressRequestor $address
 */
class NominatimRootquestor extends AbstractRootquestor
{

}
