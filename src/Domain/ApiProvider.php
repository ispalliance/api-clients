<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;

/**
 * @property-read AresRootquestor $ares
 * @property-read CrmRootquestor $crm
 * @property-read LotusRootquestor $lotus
 * @property-read PedefRootquestor $pedef
 */
class ApiProvider
{

	/** @var AbstractRootquestor[] */
	protected $rootquestors = [];

	public function add(string $name, AbstractRootquestor $rootquestor): void
	{
		if (isset($this->rootquestors[$name])) {
			throw new InvalidStateException(sprintf('Rootquestor "%s" has been already registered.'));
		}

		$this->rootquestors[$name] = $rootquestor;
	}

	public function __get(string $name): AbstractRootquestor
	{
		if (isset($this->rootquestors[$name])) {
			return $this->rootquestors[$name];
		}

		throw new InvalidStateException(sprintf('Undefined rootquestor "%s"', $name));
	}

}
