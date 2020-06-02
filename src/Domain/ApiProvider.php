<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\App\Adminus\Crm\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Nms\NmsRootquestor;
use ISPA\ApiClients\App\Ares\AresRootquestor;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Ruian\RuianRootquestor;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;

/**
 * @property-read AresRootquestor $ares
 * @property-read CrmRootquestor $adminusCrm
 * @property-read NmsRootquestor $adminusNms
 * @property-read PedefRootquestor $pedef
 * @property-read RuianRootquestor $ruian
 */
class ApiProvider
{

	/** @var AbstractRootquestor[] */
	protected $rootquestors = [];

	public function add(string $name, AbstractRootquestor $rootquestor): void
	{
		if (isset($this->rootquestors[$name])) {
			throw new InvalidStateException(sprintf('Rootquestor "%s" has been already registered.', $name));
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
