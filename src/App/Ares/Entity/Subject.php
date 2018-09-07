<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Entity;

class Subject
{

	/** @var string */
	private $name;

	/** @var string */
	private $idNumber;

	/** @var string|null */
	private $vatIdNumber;

	/** @var string */
	private $textAddress;

	public function __construct(string $name, string $idNumber, ?string $vatIdNumber, string $textAddress)
	{
		$this->name        = $name;
		$this->idNumber    = $idNumber;
		$this->vatIdNumber = $vatIdNumber;
		$this->textAddress = $textAddress;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getIdNumber(): string
	{
		return $this->idNumber;
	}

	public function getVatIdNumber(): ?string
	{
		return $this->vatIdNumber;
	}

	public function getTextAddress(): string
	{
		return $this->textAddress;
	}

}
