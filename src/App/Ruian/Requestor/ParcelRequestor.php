<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Requestor;

use ISPA\ApiClients\App\Ruian\Client\ParcelClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class ParcelRequestor extends AbstractRequestor
{

	/** @var ParcelClient */
	private $client;

	public function __construct(ParcelClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param string|int $code
	 */
	public function getByCode($code): ResponseInterface
	{
		return $this->client->getByCode($code);
	}

	/**
	 * @param string|int $cadastralAreaCode
	 */
	public function getByCadastralArea($cadastralAreaCode): ResponseInterface
	{
		return $this->client->getByCadastralArea($cadastralAreaCode);
	}

	/**
	 * @param string|int $cadastralAreaCode
	 * @param string|int $parcelNumber
	 */
	public function getByCadastralAreaAndParcelNumber($cadastralAreaCode, $parcelNumber): ResponseInterface
	{
		return $this->client->getByCadastralAreaAndParcelNumber($cadastralAreaCode, $parcelNumber);
	}

	/**
	 * @todo - missing docs
	 */
	public function getByPolygon(): ResponseInterface
	{
		return $this->client->getByPolygon();
	}

	/**
	 * @param string|int $latitude
	 * @param string|int $longtitude
	 * @param string|int $radius
	 */
	public function getByCircle($latitude, $longtitude, $radius): ResponseInterface
	{
		return $this->client->getByCircle($latitude, $longtitude, $radius);
	}

}
