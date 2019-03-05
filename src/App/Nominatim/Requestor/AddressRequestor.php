<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim\Requestor;

use ISPA\ApiClients\App\Nominatim\Client\AddressClient;
use ISPA\ApiClients\App\Nominatim\Entity\Address;
use ISPA\ApiClients\App\Nominatim\Entity\Place;
use ISPA\ApiClients\Domain\AbstractRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;

final class AddressRequestor extends AbstractRequestor
{

	/** @var AddressClient */
	private $client;

	public function __construct(AddressClient $client)
	{
		$this->client = $client;
	}

	public function findByCoords(float $lat, float $lng): ?Place
	{
		$resp = $this->client->findByCoords($lat, $lng);
		$this->assertResponse($resp);
		$data = $this->processResponse($resp);

		return Place::fromArray($data);
	}

	/**
	 * @return Place[]
	 */
	public function findByAddress(Address $address, int $limit = 10): array
	{
		$resp = $this->client->findByAddress($address, $limit);
		$this->assertResponse($resp);
		$data = $this->processResponse($resp);

		$places = [];

		foreach ($data as $placeData) {
			$places[] = Place::fromArray($placeData);
		}

		return $places;
	}

	/**
	 * @return mixed[]
	 */
	private function processResponse(ResponseInterface $response): array
	{
		$this->assertResponse($response);

		try {
			$data = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
		} catch (JsonException $e) {
			throw new ResponseException($response, 'Response is not valid JSON.');
		}

		if (isset($data['error'])) {
			throw new ResponseException($response, $data['error']['message'] ?? 'Unknown error');
		}

		return $data;
	}

}
