<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\MetaClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

/**
 * @todo - Requestor/Utils/MetaRequestor?
 */
class MetaRequestor extends AbstractRequestor
{

	/** @var MetaClient */
	private $client;

	public function __construct(MetaClient $client)
	{
		$this->client = $client;
	}

	public function getMeta(): ResponseInterface
	{
		return $this->client->getMeta();
	}

	public function getModelInfo(string $restModelName): ResponseInterface
	{
		return $this->client->getModelInfo($restModelName);
	}

}
