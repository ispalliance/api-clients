<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class BuildingObjectClient extends AbstractHttpClient
{

	private const BASE_URL = 'address-register-building-object';

	public function get(int $from = 0, int $limit = 10): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'from' => $from,
			'limit' => $limit,
		]);
		return $this->httpClient->request('GET', sprintf('%s%s', static::BASE_URL, $query));
	}

}
