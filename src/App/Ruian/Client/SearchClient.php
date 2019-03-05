<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class SearchClient extends AbstractHttpClient
{

	private const BASE_URL = 'address-register-search';

	/**
	 * @param mixed[] $filters Available filters are municipality, municipality_code, street, street_code,
	 *                         part_of_municipality, part_of_municipality_code, region, region_code, house_number,
	 *                         orientation_number, cadastral_area, cadastral_area_code, parcel_number <br>
	 *                         Also there is an special filter 'limit' to specify maximal number of results
	 * @example
	 * [
	 *         'limit' => 5,
	 *         'region_code' => 60,
	 *         'street' => 'Na%'
	 * ]
     * @todo - user enum for filters
	 */
	public function getByFilter(array $filters, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request(
            'POST',
			sprintf('%s/by-filter%s', self::BASE_URL, $query),
			[
				'body' => json_encode($filters),
			]
		);
	}

	/**
	 * @param mixed[] $filters Available filters are municipality, municipality_code, street, street_code,
	 *                         part_of_municipality, part_of_municipality_code, region, region_code, house_number,
	 *                         orientation_number, cadastral_area, cadastral_area_code, parcel_number <br>
	 *                         Also there is an special filter 'limit' to specify maximal number of results.
	 *                         This filter is used at top level
	 * @example
	 * [
	 *     'limit' => 5,
	 *     [
	 *         'region_code' => 60,
	 *         'district' => 'Teplice'
	 *     ]
	 * ]
	 */
	public function getMultipleByFilter(array $filters, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request(
            'POST',
			sprintf('%s/multiple-by-filter%s', self::BASE_URL, $query),
			[
				'body' => json_encode($filters),
			]
		);
	}

	/**
	 * @param string|int|null $limit
	 */
	public function getByFulltext(string $filter, $limit = NULL): ResponseInterface
	{
		if ($limit !== NULL) return $this->httpClient->request('GET', sprintf('%s/by-fulltext/%s/%s', self::BASE_URL, $filter, (string) $limit));

		return $this->httpClient->request('GET', sprintf('%s/by-fulltext/%s', self::BASE_URL, $filter));
	}

	public function getMultipleByFulltext(): ResponseInterface
	{
		//todo - missing docs
		return $this->httpClient->request('POST', sprintf('%s/multiple-by-fulltext', self::BASE_URL));
	}

	public function getByPolygon(): ResponseInterface
	{
		//todo - missing docs
		return $this->httpClient->request('POST', sprintf('%s/by-polygon', self::BASE_URL));
	}

	/**
	 * @param string|int $latitude
	 * @param string|int $longtitude
	 * @param string|int $radius
	 */
	public function getByCircle($latitude, $longtitude, $radius): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/%s/%s/%s', static::class, (string) $latitude, (string) $longtitude, (string) $radius));
	}

}
