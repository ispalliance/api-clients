<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

interface SoapClient
{

	/**
	 * @param mixed[] $params
	 * @return mixed
	 */
	public function call(string $method, array $params);

}
