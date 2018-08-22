<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use ISPA\ApiClients\Http\Requestor\AbstractRequestor;

abstract class AbstractRootquestor
{

	/** @var AbstractRequestor[] */
	protected $requestors = [];

	protected function addRequestor(string $name, AbstractRequestor $requestor): void
	{
		$this->requestors[$name] = $requestor;
	}

	public function __get(string $name): AbstractRequestor
	{
		if (!isset($this->requestors[$name])) {
			throw new InvalidStateException(sprintf('Undefined requestor "%s"', $name));
		}

		return $this->requestors[$name];
	}

}
