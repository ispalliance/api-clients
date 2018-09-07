<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\Exception\Logical\InvalidStateException;

abstract class AbstractRootquestor
{

	/** @var AbstractRequestor[] */
	private $requestors = [];

	public function add(string $name, AbstractRequestor $requestor): void
	{
		if (isset($this->requestors[$name])) {
			throw new InvalidStateException(sprintf('Requestor "%s" has been already registered.'));
		}

		$this->requestors[$name] = $requestor;
	}

	public function __get(string $name): AbstractRequestor
	{
		if (isset($this->requestors[$name])) {
			return $this->requestors[$name];
		}

		throw new InvalidStateException(sprintf('Undefined requestor "%s".', $name));
	}

}
