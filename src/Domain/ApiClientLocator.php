<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\App\Adminus\CrmClient;
use ISPA\ApiClients\App\Lotus\LotusClient;
use ISPA\ApiClients\App\Pedef\PedefClient;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use ISPA\ApiClients\Http\AbstractClient;

/**
 * @property-read CrmClient $crm
 * @property-read LotusClient $lotus
 * @property-read PedefClient $pedef
 */
class ApiClientLocator
{

	/** @var AbstractClient[] */
	protected $clients = [];

	public function add(string $name, AbstractClient $client): void
	{
		$this->clients[$name] = $client;
	}

	public function __get(string $name): AbstractClient
	{
		if (!isset($this->clients[$name])) {
			throw new InvalidStateException(sprintf('Undefined client "%s"', $name));
		}

		return $this->clients[$name];
	}

}
