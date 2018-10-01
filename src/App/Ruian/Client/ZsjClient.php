<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use ISPA\ApiClients\Http\Helpers;
use Psr\Http\Message\ResponseInterface;

class ZsjClient extends AbstractClient
{

	private const BASE_URL = 'address-register-zsj';

	public function get(int $from = 0, int $limit = 10): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'from' => $from,
			'limit' => $limit,
		]);
		return $this->httpClient->request('GET', sprintf('%s%s', static::BASE_URL, $query));
	}

}
