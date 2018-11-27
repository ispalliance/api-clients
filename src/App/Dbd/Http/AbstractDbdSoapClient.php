<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Http;

use ISPA\ApiClients\Domain\AbstractSoapClient;
use ISPA\ApiClients\Http\SoapClient;

abstract class AbstractDbdSoapClient extends AbstractSoapClient
{

	/** @var mixed[] */
	protected $config = [];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(SoapClient $client, array $config)
	{
		parent::__construct($client);
		$this->config = $config;
	}

}
