<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Entity;

use Contributte\Utils\Validators;
use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;

final class Person
{

	/** @var string */
	private $firstName = '';

	/** @var string */
	private $lastName = '';

	/** @var DateTimeImmutable */
	private $birthDate;

	/** @var string */
	private $pin = '';

	public function __construct(string $pin = '', string $firstName = '', string $lastName = '', ?DateTimeImmutable $birthDate = NULL)
	{
		$this->pin = $pin;
		$this->firstName = urlencode($firstName);
		$this->lastName = urlencode($lastName);
		$this->birthDate = $birthDate ?? new DateTimeImmutable('now', new DateTimeZone('UTC'));
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function getBirthDate(): string
	{
		return $this->birthDate->format('Y-m-d');
	}

	public function getPin(): string
	{
		return $this->pin;
	}

	public function isValid(): bool
	{
		if ($this->getPin() !== '') {
			return Validators::isRc($this->getPin());
		}

		if ($this->getFirstName() !== '' && $this->getLastName() !== '') {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * @return string[]
	 */
	public function toArray(): array
	{
		return [
			'pin' => $this->getPin(),
			'firstName' => $this->getFirstName(),
			'lastName' => $this->getLastName(),
			'birthDate' => $this->getBirthDate(),
		];
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$birthDate = NULL;

		if (isset($data['birthDate'])) {
			if (is_string($data['birthDate'])) {
				$birthDate = new DateTimeImmutable($data['birthDate'], new DateTimeZone('UTC'));
			} elseif ($data['birthDate'] instanceof DateTimeImmutable) {
				$birthDate = $data['birthDate'];
			} else {
				throw new InvalidArgumentException('Person\'s birthDate must be string od DateTime object.');
			}
		}

		return new self(
			isset($data['pin']) ? (string) $data['pin'] : '',
			isset($data['firstName']) ? (string) $data['firstName'] : '',
			isset($data['lastName']) ? (string) $data['lastName'] : '',
			$birthDate
		);
	}

}
