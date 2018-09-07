<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Exception\Runtime;

use ISPA\ApiClients\App\Ares\Exception\RuntimeException;

class TooManySubjectsException extends RuntimeException
{

	public static function create(string $name): self
	{
		return new self(sprintf('Too many subjects for name "%s".', $name));
	}

}
