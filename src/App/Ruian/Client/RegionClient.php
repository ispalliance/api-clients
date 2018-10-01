<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use ISPA\ApiClients\Http\Helpers;
use Psr\Http\Message\ResponseInterface;

class RegionClient extends AbstractClient
{

	private const BASE_URL = 'address-register-region';

	public function get(int $from = 0, int $limit = 10): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'from' => $from,
			'limit' => $limit,
		]);
		return $this->httpClient->request('GET', sprintf('%s%s', static::BASE_URL, $query));
	}

	public function getAll(): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/all', static::BASE_URL));
	}

}
