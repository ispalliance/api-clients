<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus;

use ISPA\ApiClients\App\Lotus\Requestor\CalendarRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\SnippetRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UserRequestor;
use ISPA\ApiClients\Domain\AbstractRootquestor;

/**
 * @property-read CalendarRequestor $calendar
 * @property-read ProcessRequestor $process
 * @property-read SnippetRequestor $snippet
 * @property-read UserRequestor $user
 */
class LotusRootquestor extends AbstractRootquestor
{

}
