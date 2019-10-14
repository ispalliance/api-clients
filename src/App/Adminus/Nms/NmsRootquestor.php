<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Nms;

use ISPA\ApiClients\App\Adminus\Nms\Requestor\AreaRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\DeviceRequestor;
use ISPA\ApiClients\App\Adminus\Nms\Requestor\PopRequestor;
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read AreaRequestor $area
 * @property-read DeviceRequestor $device
 * @property-read PopRequestor $pop
 */
class NmsRootquestor extends AbstractRootquestor
{

}
