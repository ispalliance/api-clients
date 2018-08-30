<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef;

use ISPA\ApiClients\App\Pedef\Requestor\BaseRequestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\Http\AbstractRootquestor;

/**
 * @property-read ThumbnailRequestor $thumbnail
 * @method ThumbnailRequestor generate()
 */
class PedefRootquestor extends AbstractRootquestor
{

	public function add(string $name, BaseRequestor $requestor): void
	{
		$this->addRequestor($name, $requestor);
	}

}
