<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim\Requestor;

use ISPA\ApiClients\App\Nominatim\Client\AddressClient;
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

		return $this->processResponse($resp);
	}

	private function processResponse(ResponseInterface $response): ?Place
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

		return Place::fromArray($data);
	}

}
