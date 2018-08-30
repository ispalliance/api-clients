<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Requestor;

use ISPA\ApiClients\App\Pedef\PedefClient;
use ISPA\ApiClients\Http\Requestor\AbstractRequestor;

abstract class BaseRequestor extends AbstractRequestor
{

	/** @var PedefClient */
	protected $client;

	public function __construct(PedefClient $client)
	{
		$this->client = $client;
	}

}
