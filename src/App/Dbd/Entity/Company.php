<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Entity;

use Contributte\Utils\Validators;

final class Company
{

	/** @var string */
	private $firmName;

	/** @var int|null */
	private $id;

	public function __construct(?int $id = NULL, string $firmName = '')
	{
		$this->id = $id;
		$this->firmName = $firmName;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getFirmName(): string
	{
		return $this->firmName;
	}

	public function isValid(): bool
	{
		return Validators::isIco((string) $this->getId());
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'id' => $this->getId(),
			'firmName' => $this->getFirmName(),
		];
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		return new self(
			isset($data['id']) ? (int) $data['id'] : NULL,
			isset($data['firmName']) ? (string) $data['firmName'] : ''
		);
	}

}
