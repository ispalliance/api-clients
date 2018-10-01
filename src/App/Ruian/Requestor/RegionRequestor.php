<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\RegionClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class RegionRequestor extends AbstractRequestor
{

	/** @var RegionClient */
	private $client;

	public function __construct(RegionClient $client)
	{
		$this->client = $client;
	}

	public function get(int $from = 0, int $limit = 10): ResponseInterface
	{
		return $this->client->get($from, $limit);
	}

	public function getAll(): ResponseInterface
	{
		return $this->client->getAll();
	}

}
