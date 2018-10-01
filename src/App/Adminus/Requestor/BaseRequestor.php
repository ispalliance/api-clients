<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\CrmClient;
use ISPA\ApiClients\Http\Requestor\AbstractRequestor;

abstract class BaseRequestor extends AbstractRequestor
{

	/** @var CrmClient */
	protected $client;

	public function __construct(CrmClient $client)
	{
		$this->client = $client;
	}

}
