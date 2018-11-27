<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Result;

use DateTimeImmutable;
use InvalidArgumentException;
use ISPA\ApiClients\App\Dbd\Entity\Company;
use ISPA\ApiClients\App\Dbd\Entity\Person;
use ISPA\ApiClients\Utils\Xml\Helpers;
use SimpleXMLElement;

final class Result
{

	/** @var Person|Company */
	private $subject;

	/** @var DateTimeImmutable */
	private $datePerformed;

	/** @var SimpleXMLElement */
	private $xml;

	/** @var CEEResult[] */
	private $ceeResults = [];

	/** @var InsolventResult[] */
	private $insolventResults = [];

	/** @var DebtResult[] */
	private $debtResults = [];

	/**
	 * @param Person|Company $subject
	 */
	public function __construct(object $subject, SimpleXMLElement $xml, ?DateTimeImmutable $datePerformed = NULL)
	{
		$this->datePerformed = $datePerformed ?? new DateTimeImmutable();
		$this->subject = $subject;
		$this->xml = $xml;

		$this->processXml();
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'subject_type' => $this->subject instanceof Person ? 'person' : 'company',
			'subject' => $this->subject->toArray(),
			'xml' => $this->xml->asXML(),
			'date_performed' => $this->datePerformed->format('Y-m-d H:i:s'),
		];
	}

	/**
	 * @param mixed[] $data
	 */
	public static function fromArray(array $data): self
	{
		$required = array_flip(['subject_type', 'subject', 'xml', 'date_performed']);
		if (count(array_intersect_key($required, $data)) !== count($required)) {
			throw new InvalidArgumentException('Cannot create Result object. Some mandatory keys missing.');
		}

		if ($data['subject_type'] === 'person') {
			$subject = Person::fromArray($data['subject']);
		} else {
			$subject = Company::fromArray($data['subject']);
		}

		$xml = Helpers::strToXml($data['xml']);
		$performed = new DateTimeImmutable($data['date_performed']);

		return new self($subject, $xml, $performed);
	}

	public function isDebtor(): bool
	{
		return !(
			count($this->ceeResults) === 0 &&
			count($this->insolventResults) === 0 &&
			count($this->debtResults) === 0
		);
	}

	/** @return Person|Company */
	public function getSubject(): object
	{
		return $this->subject;
	}

	public function isSubjectCompany(): bool
	{
		return $this->subject instanceof Company;
	}

	public function isSubjectPerson(): bool
	{
		return $this->subject instanceof Person;
	}

	/** @return CEEResult[] */
	public function getCeeResults(): array
	{
		return $this->ceeResults;
	}

	/** @return InsolventResult[] */
	public function getInsolventResult(): array
	{
		return $this->insolventResults;
	}

	/** @return DebtResult[] */
	public function getDebtResults(): array
	{
		return $this->debtResults;
	}

	public function getDatePerformed(): DateTimeImmutable
	{
		return $this->datePerformed;
	}

	private function processXml(): void
	{
		if ($this->hasSection('exekuce')) {
			$this->processCeeResults();
		}

		if ($this->hasSection('insolvence')) {
			$this->processInsolvencyResults();
		}

		if ($this->hasSection('dluh')) {
			$this->processDebtResults();
		}
	}

	private function hasSection(string $type): bool
	{
		if (!$this->xml->$type) {
			return FALSE;
		}

		return ((int) $this->xml->$type->attributes()->pritomny) > 0;
	}

	private function processCeeResults(): void
	{
		$this->ceeResults = [];

		foreach ($this->xml->exekuce->zaznam as $record) {
			$attrs = $record->attributes();

			$result = new CEEResult();

			$result->ceeId = (string) $attrs->spisovaZnacka;
			$result->ceePerson = (string) $attrs->exekutor;
			$result->ceeDate = new DateTimeImmutable((string) $attrs->datumZapisu);
			$result->event = (string) $attrs->udalost;
			$result->note = (string) $attrs->poznamka;
			$result->address = (string) $attrs->adresa;

			$this->ceeResults[] = $result;
		}
	}

	private function processInsolvencyResults(): void
	{
		$this->insolventResults = [];

		foreach ($this->xml->insolvence->zaznam as $record) {
			$result = new InsolventResult();
			$attrs = $record->attributes();

			$result->name = (string) $attrs->jmeno;
			$result->insolventId = (string) $attrs->spisovaZnacka;

			$this->insolventResults[] = $result;
		}
	}

	private function processDebtResults(): void
	{
		$this->debtResults = [];

		foreach ($this->xml->dluh->zaznam as $record) {
			$result = new DebtResult();
			$attrs = $record->attributes();

			$result->debt = (float) $attrs->dluh;
			$result->debtPaid = (float) $attrs->uhrazeno;

			$this->debtResults[] = $result;
		}
	}

}
