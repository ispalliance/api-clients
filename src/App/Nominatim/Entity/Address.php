<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim\Entity;

final class Address
{

	/** @var string */
	private $countryCode = '';

	/** @var string */
	private $country = '';

	/** @var string */
	private $postcode = '';

	/** @var string */
	private $state = '';

	/** @var string */
	private $county = '';

	/** @var string */
	private $town = '';

	/** @var string */
	private $suburb = '';

	/** @var string */
	private $road = '';

	/** @var string */
	private $houseNumber = '';

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$a = new self();
		$a->countryCode = $data['country_code'] ?? '';
		$a->country = $data['country'] ?? '';
		$a->postcode = $data['postcode'] ?? '';
		$a->state = $data['state'] ?? '';
		$a->county = $data['county'] ?? '';
		$a->suburb = $data['suburb'] ?? '';
		$a->road = $data['road'] ?? '';
		$a->houseNumber = $data['house_number'] ?? '';

		return $a;
	}

	public function toQuery(): string
	{
		$q = $this->houseNumber . ' ' . $this->road;
		$q .= $this->town !== '' ? ', ' . $this->town : '';
		$q .= $this->postcode !== '' ? ', ' . $this->postcode : '';
		$q .= $this->country !== '' ? ', ' . $this->country : '';

		return $q;
	}

	public function getCountryCode(): string
	{
		return $this->countryCode;
	}

	public function setCountryCode(string $countryCode): void
	{
		$this->countryCode = $countryCode;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	public function getPostcode(): string
	{
		return $this->postcode;
	}

	public function setPostcode(string $postcode): void
	{
		$this->postcode = $postcode;
	}

	public function getState(): string
	{
		return $this->state;
	}

	public function setState(string $state): void
	{
		$this->state = $state;
	}

	public function getCounty(): string
	{
		return $this->county;
	}

	public function setCounty(string $county): void
	{
		$this->county = $county;
	}

	public function getTown(): string
	{
		return $this->town;
	}

	public function setTown(string $town): void
	{
		$this->town = $town;
	}

	public function getSuburb(): string
	{
		return $this->suburb;
	}

	public function setSuburb(string $suburb): void
	{
		$this->suburb = $suburb;
	}

	public function getRoad(): string
	{
		return $this->road;
	}

	public function getStreet(): string
	{
		$this->getRoad();
	}

	public function setRoad(string $road): void
	{
		$this->road = $road;
	}

	public function setStreet(string $street): void
	{
		$this->setRoad($street);
	}

	public function getHouseNumber(): string
	{
		return $this->houseNumber;
	}

	public function setHouseNumber(string $houseNumber): void
	{
		$this->houseNumber = $houseNumber;
	}

}
