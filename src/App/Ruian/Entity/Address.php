<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Entity;

use stdClass;

class Address extends stdClass
{

	/** @var ?string */
	public $code;

	/** @var ?string */
	public $street;

	/** @var ?string */
	public $houseNumber;

	/** @var ?string */
	public $orientationNumber;

	/** @var ?string */
	public $zipCode;

	/** @var ?string */
	public $district;

	/** @var ?string */
	public $region;

	/** @var ?string */
	public $municipality;

	/** @var ?string */
	public $partOfMunicipality;

	/** @var ?string */
	public $zsj;

	/** @var ?string */
	public $houseNumberType = 'e'; // 'e' | 'p'

	/** @var ?string */
	public $country = 'CZ';

	/**
	 * @param mixed[] $data
	 * @return Address
	 */
	public static function fromArray(array $data): object
	{
		$self = new self();

		foreach ($data as $key => $val) {
			$self->$key = (string) $val;
		}

		return $self;
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return (array) $this;
	}

	public function toString(): string
	{
		$out = '';
		$out .= $this->street ?? '';
		$out .= $this->houseNumber !== NULL
            ? ' ' . $this->houseNumber
            : '';
		$out .= $this->orientationNumber !== NULL
            ? '/' . $this->orientationNumber
            : '';
		$out .= $this->zipCode !== NULL
            ? ', ' . $this->zipCode
            : '';
		$out .= $this->municipality !== NULL
            ? ', ' . $this->municipality
            : '';
		$out .= $this->partOfMunicipality !== NULL
            ? ' - ' . $this->partOfMunicipality
            : '';
		$out .= $this->district !== NULL
            ? ' (' . $this->district . ')'
            : '';

		return $out;
	}

	public function getCode(): ?string
	{
		return $this->code;
	}

	public function getStreet(): ?string
	{
		return $this->street;
	}

	public function getHouseNumber(): ?string
	{
		return $this->houseNumber;
	}

	public function getOrientationNumber(): ?string
	{
		return $this->orientationNumber;
	}

	public function getZipCode(): ?string
	{
		return $this->zipCode;
	}

	public function getDistrict(): ?string
	{
		return $this->district;
	}

	public function getRegion(): ?string
	{
		return $this->region;
	}

	public function getMunicipality(): ?string
	{
		return $this->municipality;
	}

	public function getPartOfMunicipality(): ?string
	{
		return $this->partOfMunicipality;
	}

	public function getZsj(): ?string
	{
		return $this->zsj;
	}

	public function getHouseNumberType(): ?string
	{
		return $this->houseNumberType;
	}

	public function getCountry(): ?string
	{
		return $this->country;
	}

}
