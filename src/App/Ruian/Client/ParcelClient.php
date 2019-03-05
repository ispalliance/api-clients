<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class ParcelClient extends AbstractHttpClient
{

	private const BASE_URL = 'address-register-parcel';

	/**
	 * @param string|int $code
	 */
	public function getByCode($code): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/%s', self::BASE_URL, (string) $code));
	}

	/**
	 * @param string|int $cadastralAreaCode
	 */
	public function getByCadastralArea($cadastralAreaCode): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/by-cadastral-area/%s', self::BASE_URL, (string) $cadastralAreaCode));
	}

	/**
	 * @param string|int $cadastralAreaCode
	 * @param string|int $parcelNumber
	 */
	public function getByCadastralAreaAndParcelNumber($cadastralAreaCode, $parcelNumber): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/by-cadastral-area-and-parcel-number/%s/%s', self::BASE_URL, (string) $cadastralAreaCode, (string) $parcelNumber));
	}

	/**
	 * @todo - missing docs
	 */
	public function getByPolygon(): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s', self::BASE_URL));
	}

	/**
	 * @param string|int $latitude
	 * @param string|int $longtitude
	 * @param string|int $radius
	 */
	public function getByCircle($latitude, $longtitude, $radius): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/%s/%s/%s', static::class, (string) $latitude, (string) $longtitude, (string) $radius));
	}

}
