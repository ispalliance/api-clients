<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class CadastralAreaClient extends AbstractHttpClient
{

	private const BASE_URL = 'address-register-cadastral-area';

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
