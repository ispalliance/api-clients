<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use Psr\Http\Message\ResponseInterface;

class MetaClient extends AbstractClient
{

	private const BASE_URL = 'meta';

	public function getMeta(): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s', static::BASE_URL));
	}

	public function getModelInfo(string $restModelName): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/model-info/%s', static::BASE_URL, $restModelName));
	}

}
