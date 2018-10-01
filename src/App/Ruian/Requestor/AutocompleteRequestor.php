<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\AutocompleteClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class AutocompleteRequestor extends AbstractRequestor
{

	/** @var AutocompleteClient */
	private $client;

	public function __construct(AutocompleteClient $client)
	{
		$this->client = $client;
	}

	public function getDistrictsByFilter(string $filter): ResponseInterface
	{
		return $this->client->getDistrictsByFilter($filter);
	}

	public function getMunicipalitiesWithPartsByFilter(string $filter): ResponseInterface
	{
		return $this->client->getMunicipalitiesWithPartsByFilter($filter);
	}

	/**
	 * @param string|int $cityCode
	 */
	public function getStreetsByCityCodeAndFilter($cityCode, string $filter): ResponseInterface
	{
		return $this->client->getStreetsByCityCodeAndFilter($cityCode, $filter);
	}

	/**
	 * @param string|int $cityPartCode
	 */
	public function getStreetsByCityPartCodeAndFilter($cityPartCode, string $filter): ResponseInterface
	{
		return $this->client->getStreetsByCityPartCodeAndFilter($cityPartCode, $filter);
	}

	/**
	 * @param string|int $streetCode
	 */
	public function getHouseNumbersByStreetCode($streetCode): ResponseInterface
	{
		return $this->client->getHouseNumbersByStreetCode($streetCode);
	}

	/**
	 * @param string|int $cityCode
	 */
	public function getHouseNumbersWithoutStreetByCityCode($cityCode): ResponseInterface
	{
		return $this->client->getHouseNumbersWithoutStreetByCityCode($cityCode);
	}

	/**
	 * @param string|int $cityPartCode
	 */
	public function getHouseNumbersWithoutStreetByCityPartCode($cityPartCode): ResponseInterface
	{
		return $this->client->getHouseNumbersWithoutStreetByCityCode($cityPartCode);
	}

}
