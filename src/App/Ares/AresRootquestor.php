<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares;

use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read SubjectRequestor $subject
 * @property-read AddressRequestor $address
 */
class AresRootquestor extends AbstractRootquestor
{

}
