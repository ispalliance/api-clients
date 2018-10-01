<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\SearchClient;
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
	 */
	public function getMultipleByFilter(array $filters, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getMultipleByFilter($filters, $expanded);
	}

	/**
	 * @param string|int|null $limit
	 */
	public function getByFulltext(string $filter, $limit = NULL): ResponseInterface
	{
		return $this->client->getByFulltext($filter, $limit);
	}

	public function getMultipleByFulltext(): ResponseInterface
	{
		return $this->client->getMultipleByFulltext();
	}

	public function getByPolygon(): ResponseInterface
	{
		return $this->client->getByPolygon();
	}

	/**
	 * @param string|int $latitude
	 * @param string|int $longtitude
	 * @param string|int $radius
	 */
	public function getByCircle($latitude, $longtitude, $radius): ResponseInterface
	{
		return $this->client->getByCircle($latitude, $longtitude, $radius);
	}

}
