<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\App\Ruian\Client\SearchClient;
use ISPA\ApiClients\App\Ruian\Entity\Address;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class SearchRequestor extends AbstractRequestor
{

	/** @var SearchClient */
	private $client;

	public function __construct(SearchClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param mixed[] $filters Available filters are municipality, municipality_code, street, street_code,
	 *                         part_of_municipality, part_of_municipality_code, region, region_code, house_number,
	 *                         orientation_number, cadastral_area, cadastral_area_code, parcel_number <br>
	 *                         Also there is an special filter 'limit' to specify maximal number of results
	 * @example
	 *                         [
	 *                         'limit' => 5,
	 *                         'region_code' => 60,
	 *                         'street' => 'Na%'
	 *                         ]
	 */
	public function getByFilter(array $filters, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByFilter($filters, $expanded);
	}

	/**
	 * @param mixed[] $filters Available filters are municipality, municipality_code, street, street_code,
	 *                         part_of_municipality, part_of_municipality_code, region, region_code, house_number,
	 *                         orientation_number, cadastral_area, cadastral_area_code, parcel_number <br>
	 *                         Also there is an special filter 'limit' to specify maximal number of results.
	 *                         This filter is used at top level
	 * @example
	 *                         [
	 *                         'limit' => 5,
	 *                         [
	 *                         'region_code' => 60,
	 *                         'district' => 'Teplice'
	 *                         ]
	 *                         ]
	 * @return Address[]
	 */
	public function getMultipleByFilter(array $filters, bool $expanded = FALSE): array
	{
		$response = $this->client->getMultipleByFilter($filters, $expanded);
		$this->assertResponse($response);

		return $this->toAddresses(ResponseDataExtractor::extractData($response));
	}

	/**
	 * @param string|int|null $limit
	 * @return Address[]
	 */
	public function getByFulltext(string $filter, $limit = NULL): array
	{
		$response = $this->client->getByFulltext($filter, $limit);
		$this->assertResponse($response);

		return $this->toAddresses(ResponseDataExtractor::extractData($response));
	}

	/**
	 * @return Address[]
	 */
	public function getMultipleByFulltext(): array
	{
		$response = $this->client->getMultipleByFulltext();
		$this->assertResponse($response);

		return $this->toAddresses(ResponseDataExtractor::extractData($response));
	}

	/**
	 * @return Address[]
	 */
	public function getByPolygon(): array
	{
		$response = $this->client->getByPolygon();
		$this->assertResponse($response);

		return $this->toAddresses(ResponseDataExtractor::extractData($response));
	}

	/**
	 * @param string|int $latitude
	 * @param string|int $longtitude
	 * @param string|int $radius
	 * @return Address[]
	 */
	public function getByCircle($latitude, $longtitude, $radius): array
	{
		$response = $this->client->getByCircle($latitude, $longtitude, $radius);
		$this->assertResponse($response);

		return $this->toAddresses(ResponseDataExtractor::extractData($response));
	}

	/**
	 * @param mixed[] $items
	 * @return Address[]
	 */
	private function toAddresses(array $items): array
	{
		$addresses = [];
		foreach ($items as $item) {
			$item['country'] = 'CZ';
			$addresses[] = Address::fromArray($item);
		}

		return $addresses;
	}

}
