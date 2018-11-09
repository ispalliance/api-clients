<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Entity;

use InvalidArgumentException;

final class Coordinates
{

	/** @var string */
	private $lat;

	/** @var string */
	private $lng;

	/**
	 * @param string|float|int $lat
	 * @param string|float|int $lng
	 */
	public function __construct($lat, $lng)
	{
		$this->lat = (string) $lat;
		$this->lng = (string) $lng;
	}

	/**
	 * @param mixed[] $coords
	 */
	public static function fromArray(array $coords): self
	{
		if (count($coords) === 2) {
			return new self($coords[0], $coords[1]);
		}

		throw new InvalidArgumentException('You must provide array of two values to create Coordinates from array');
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'lat' => $this->getLat(),
			'lng' => $this->getLng(),
		];
	}

	public function getLat(): string
	{
		return $this->lat;
	}

	public function getLng(): string
	{
		return $this->lng;
	}

}
