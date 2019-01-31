<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Nominatim\Entity;

final class Place
{

	/** @var string */
	private $id = '';

	/** @var string */
	private $licence = '';

	/** @var string */
	private $osmType = '';

	/** @var string */
	private $osmId = '';

	/** @var float */
	private $lat = 0;

	/** @var float */
	private $lng = 0;

	/** @var string */
	private $displayName = '';

	/** @var Address */
	private $address;

	/** @var float[] */
	private $boundingBox = [];

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$p = new self();

		$p->id = $data['place_id'] ?? '';
		$p->licence = $data['licence'] ?? '';
		$p->osmType = $data['osm_type'] ?? '';
		$p->osmId = $data['osm_id'] ?? '';
		$p->displayName = $data['display_name'] ?? '';

		$p->lat = isset($data['lat']) ? (float) $data['lat'] : 0;
		$p->lng = isset($data['lon']) ? (float) $data['lon'] : 0;

		if (isset($data['boundingbox']) && is_array($data['boundingbox'])) {
			foreach ($data['boundingbox'] as $coord) {
				$p->boundingBox[] = (float) $coord;
			}
		}

		if (isset($data['address'])) {
			$p->address = Address::fromArray($data['address']);
		}

		return $p;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getLicence(): string
	{
		return $this->licence;
	}

	public function getOsmType(): string
	{
		return $this->osmType;
	}

	public function getOsmId(): string
	{
		return $this->osmId;
	}

	public function getLat(): float
	{
		return $this->lat;
	}

	public function getLng(): float
	{
		return $this->lng;
	}

	public function getDisplayName(): string
	{
		return $this->displayName;
	}

	public function getAddress(): Address
	{
		return $this->address;
	}

	/**
	 * @return float[]
	 */
	public function getBoundingBox(): array
	{
		return $this->boundingBox;
	}

}
