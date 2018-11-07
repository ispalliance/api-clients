<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Entity;

final class ExpandedAddress extends Address
{

	/** @var ?string */
	public $streetCode;

	/** @var ?string */
	public $districtCode;

	/** @var ?string */
	public $regionCode;

	/** @var ?string */
	public $zsjCode;

	/** @var ?string */
	public $municipalityCode;

	/** @var ?string */
	public $partOfMunicipalityCode;

	/** @var ?string */
	public $buildingObjectCode;

	/** @var ?string */
	public $entranceCode;

	/** @var ?string */
	public $numberOfApartments;

	/** @var ?string */
	public $numberOfFloors;

	/** @var ?string */
	public $gpsPoint;

	/** @var ?string */
	public $cadastralAreaCode;

	/** @var ?string */
	public $cadastralArea;

	/** @var ?string */
	public $parcelCode;

	/** @var ?string */
	public $parcelNumber;

	/**
	 * @param mixed[] $data
	 * @return ExpandedAddress
	 */
	public static function fromArray(array $data): object
	{
		$self = new self();

		foreach ($data as $key => $val) {
			$self->$key = (string) $val;
		}

		return $self;
	}

	public function getStreetCode(): ?string
	{
		return $this->streetCode;
	}

	public function getDistrictCode(): ?string
	{
		return $this->districtCode;
	}

	public function getRegionCode(): ?string
	{
		return $this->regionCode;
	}

	public function getZsjCode(): ?string
	{
		return $this->zsjCode;
	}

	public function getMunicipalityCode(): ?string
	{
		return $this->municipalityCode;
	}

	public function getPartOfMunicipalityCode(): ?string
	{
		return $this->partOfMunicipalityCode;
	}

	public function getBuildingObjectCode(): ?string
	{
		return $this->buildingObjectCode;
	}

	public function getEntranceCode(): ?string
	{
		return $this->entranceCode;
	}

	public function getNumberOfApartments(): ?string
	{
		return $this->numberOfApartments;
	}

	public function getNumberOfFloors(): ?string
	{
		return $this->numberOfFloors;
	}

	public function getGpsPoint(): ?string
	{
		return $this->gpsPoint;
	}

	public function getCadastralAreaCode(): ?string
	{
		return $this->cadastralAreaCode;
	}

	public function getCadastralArea(): ?string
	{
		return $this->cadastralArea;
	}

	public function getParcelCode(): ?string
	{
		return $this->parcelCode;
	}

	public function getParcelNumber(): ?string
	{
		return $this->parcelNumber;
	}

}
