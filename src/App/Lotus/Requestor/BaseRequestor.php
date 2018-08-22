<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\LotusClient;
use ISPA\ApiClients\Http\Requestor\AbstractRequestor;

abstract class BaseRequestor extends AbstractRequestor
{

	/** @var LotusClient */
	protected $client;

	public function __construct(LotusClient $client)
	{
		$this->client = $client;
	}

}
