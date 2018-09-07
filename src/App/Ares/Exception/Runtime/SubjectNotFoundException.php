<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Exception\Runtime;

use ISPA\ApiClients\App\Ares\Exception\RuntimeException;
use Throwable;

class SubjectNotFoundException extends RuntimeException
{

	public static function create(string $idNumber, ?Throwable $previous = null): self
	{
		return new self(sprintf('Subject for identification number "%s" not found.', $idNumber), 0, $previous);
	}

}
