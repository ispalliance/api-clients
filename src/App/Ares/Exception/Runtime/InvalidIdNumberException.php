<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Exception\Runtime;

use ISPA\ApiClients\App\Ares\Exception\RuntimeException;

class InvalidIdNumberException extends RuntimeException
{

	public static function create(string $idNumber): self
	{
		return new self(sprintf('Invalid identification number "%s".', $idNumber));
	}

}
