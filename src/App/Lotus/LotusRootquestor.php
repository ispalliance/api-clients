<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus;

use ISPA\ApiClients\App\Lotus\Requestor\BaseRequestor;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use ISPA\ApiClients\Http\AbstractRootquestor;

/**
 * @property-read UsersRequestor $users
 */
class LotusRootquestor extends AbstractRootquestor
{

	public function add(string $name, BaseRequestor $requestor): void
	{
		$this->addRequestor($name, $requestor);
	}

}
