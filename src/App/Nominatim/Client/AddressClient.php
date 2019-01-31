<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim\Client;

use ISPA\ApiClients\App\Nominatim\Entity\Address;
use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

final class AddressClient extends AbstractHttpClient
{

	private const FORMAT = 'json';

	public function findByCoords(float $lat, float $lng): ResponseInterface
	{
		$params = [
			'lat' => $lat,
			'lon' => $lng,
			'addressdetails' => 1,
			'format' => self::FORMAT,
		];
		$url = sprintf('/reverse?%s', http_build_query($params));

		return $this->httpClient->request('GET', $url);
	}

	public function findByAddress(Address $address, int $limit = 10): ResponseInterface
	{
		$params = [
			'q' => $address->toQuery(),
			'limit' => $limit,
			'addressdetails' => 1,
			'format' => self::FORMAT,
		];
		$url = sprintf('?%s', http_build_query($params));

		return $this->httpClient->request('GET', $url);
	}

}
