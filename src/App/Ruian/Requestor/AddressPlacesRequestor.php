<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\AddressPlacesClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

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
	 */
	public function getByCode($code, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByCode($code, $expanded);
	}

	/**
	 * @param string[]|int[] $codes [1,2,3,4,5]
	 */
	public function getByCodes(array $codes, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByCodes($codes, $expanded);
	}

	public function getByMunicipality(string $municipality, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByMunicipality($municipality, $expanded);
	}

	public function getByMunicipalityPart(string $partOfMunicipality, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByMunicipalityPart($partOfMunicipality, $expanded);
	}

	public function getByStreet(string $street, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByStreet($street, $expanded);
	}

	public function getByRegion(string $region, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByRegion($region, $expanded);
	}

	public function getByDistrict(string $district, bool $expanded = FALSE): ResponseInterface
	{
		return $this->client->getByDistrict($district, $expanded);
	}

}
