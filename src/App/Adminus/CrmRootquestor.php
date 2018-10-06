<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus;

use ISPA\ApiClients\App\Adminus\Requestor\AccountingEntityRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\ContractRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\CustomerRequestor;
use ISPA\ApiClients\App\Adminus\Requestor\UserRequestor;
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read AccountingEntityRequestor $accountingEntity
 * @property-read ContractRequestor $contract
 * @property-read CustomerRequestor $customer
 * @property-read UserRequestor $user
 */
class CrmRootquestor extends AbstractRootquestor
{

}
