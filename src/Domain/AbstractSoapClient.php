<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Domain;

use ISPA\ApiClients\Http\SoapClient;

abstract class AbstractSoapClient
{

	/** @var SoapClient */
	protected $soapClient;

	public function __construct(SoapClient $client)
	{
		$this->soapClient = $client;
	}

}
