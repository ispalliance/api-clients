<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Entity;

use DateTimeImmutable;
use DateTimeZone;

final class TestPerson
{

	public static function get(): Person
	{
		return new Person('', 'Martin', 'Šárfy', new DateTimeImmutable('1981-04-14', new DateTimeZone('UTC')));
	}

}
