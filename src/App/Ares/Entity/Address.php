<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Entity;

class Address
{

	/** @var string */
	private $name;

	/** @var string */
	private $street;

	/** @var string */
	private $houseNumber;

	/** @var string */
	private $orientationNumber;

	/** @var string */
	private $city;

	/** @var string */
	private $cityPart;

	/** @var string */
	private $postcode;

	public function __construct(string $name, string $street, string $houseNumber, string $orientationNumber, string $city, string $cityPart, string $postcode)
	{
		$this->name              = $name;
		$this->street            = $street;
		$this->houseNumber       = $houseNumber;
		$this->orientationNumber = $orientationNumber;
		$this->city              = $city;
		$this->cityPart          = $cityPart;
		$this->postcode          = $postcode;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function getHouseNumber(): string
	{
		return $this->houseNumber;
	}

	public function getOrientationNumber(): string
	{
		return $this->orientationNumber;
	}

	public function getCity(): string
	{
		return $this->city;
	}

	public function getCityPart(): string
	{
		return $this->cityPart;
	}

	public function getPostcode(): string
	{
		return $this->postcode;
	}

}
