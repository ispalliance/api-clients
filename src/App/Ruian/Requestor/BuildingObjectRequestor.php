<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\BuildingObjectClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class BuildingObjectRequestor extends AbstractRequestor
{

	/** @var BuildingObjectClient */
	private $client;

	public function __construct(BuildingObjectClient $client)
	{
		$this->client = $client;
	}

	public function get(int $from = 0, int $limit = 10): ResponseInterface
	{
		return $this->client->get($from, $limit);
	}

}
