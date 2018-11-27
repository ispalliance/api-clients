<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http\Soaper;

use ISPA\ApiClients\Exception\Runtime\RequestException;
use ISPA\ApiClients\Http\SoapClient;
use SoapClient as NativeSoapClient;
use SoapFault;

class SoaperClient implements SoapClient
{

	/** @var NativeSoapClient */
	protected $client;

	public function __construct(NativeSoapClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param mixed[] $params
	 * @return mixed
	 */
	public function call(string $method, array $params)
	{
		try {
			return $this->client->__soapCall($method, $params);
		} catch (SoapFault $e) {
			throw new RequestException($e->getMessage(), 0, $e);
		}
	}

}
