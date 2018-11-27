<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Result;

use DateTimeImmutable;

final class CEEResult
{

	/** @var string */
	public $ceeId = '';

	/** @var string */
	public $ceePerson = '';

	/** @var DateTimeImmutable */
	public $ceeDate;

	/** @var string */
	public $event = '';

	/** @var string */
	public $note = '';

	/** @var string */
	public $address = '';

}
