<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use ISPA\ApiClients\Http\AbstractRootquestor;

/**
 * @property-read CrmRootquestor $crm
 * @property-read LotusRootquestor $lotus
 * @property-read PedefRootquestor $pedef
 * @method CrmRootquestor getCrm()
 * @method LotusRootquestor getLotus()
 * @method PedefRootquestor getPedef()
 */
class ApiManager
{

	/** @var AbstractRootquestor[] */
	protected $rootquestors = [];

	public function add(string $name, AbstractRootquestor $rootquestor): void
	{
		$this->rootquestors[$name] = $rootquestor;
	}

	public function __get(string $name): AbstractRootquestor
	{
		if (!isset($this->rootquestors[$name])) {
			throw new InvalidStateException(sprintf('Undefined rootquestor "%s"', $name));
		}

		return $this->rootquestors[$name];
	}

}
