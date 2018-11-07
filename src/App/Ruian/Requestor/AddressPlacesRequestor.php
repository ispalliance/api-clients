<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ispa\AddressCreator;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\App\Ruian\Client\AddressPlacesClient;
use ISPA\ApiClients\App\Ruian\Entity\Address;
use ISPA\ApiClients\App\Ruian\Entity\ExpandedAddress;
use ISPA\ApiClients\Domain\AbstractRequestor;

class AddressPlacesRequestor extends AbstractRequestor
{

	/** @var AddressPlacesClient */
	private $client;

	public function __construct(AddressPlacesClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param string|int $code
	 * @return Address|ExpandedAddress|null
	 */
	public function getByCode($code, bool $expanded = FALSE): ?object
	{
		$response = $this->client->getByCode($code, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddress(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @param string[]|int[] $codes [1,2,3,4,5]
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByCodes(array $codes, bool $expanded = FALSE): array
	{
		$response = $this->client->getByCodes($codes, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByMunicipality(string $municipality, bool $expanded = FALSE): array
	{
		$response = $this->client->getByMunicipality($municipality, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByMunicipalityPart(string $partOfMunicipality, bool $expanded = FALSE): array
	{
		$response = $this->client->getByMunicipalityPart($partOfMunicipality, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByStreet(string $street, bool $expanded = FALSE): array
	{
		$response = $this->client->getByStreet($street, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByRegion(string $region, bool $expanded = FALSE): array
	{
		$response = $this->client->getByRegion($region, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

	/**
	 * @return Address[]|ExpandedAddress[]
	 */
	public function getByDistrict(string $district, bool $expanded = FALSE): array
	{
		$response = $this->client->getByDistrict($district, $expanded);
		$this->assertResponse($response, [200, 404]);

		return AddressCreator::toProperAddresses(ResponseDataExtractor::extractData($response), $expanded);
	}

}
