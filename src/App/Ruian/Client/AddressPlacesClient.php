<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ruian\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class AddressPlacesClient extends AbstractHttpClient
{

	private const BASE_URL = 'address-register-address-places';

	/**
	 * @param string|int $code
	 */
	public function getByCode($code, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-code/%s%s', self::BASE_URL, (string) $code, $query));
	}

	/**
	 * @param string[]|int[] $codes [1,2,3,4,5]
	 */
	public function getByCodes(array $codes, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request(
			'POST',
			sprintf('%s/by-codes%s', self::BASE_URL, $query),
			[
				'body' => json_encode($codes),
			]
		);
	}

	public function getByMunicipality(string $municipality, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-municipality/%s%s', self::BASE_URL, $municipality, $query));
	}

	public function getByMunicipalityPart(string $partOfMunicipality, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-part-of-municipality/%s%s', self::BASE_URL, $partOfMunicipality, $query));
	}

	public function getByStreet(string $street, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-street/%s%s', self::BASE_URL, $street, $query));
	}

	public function getByRegion(string $region, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-region/%s%s', self::BASE_URL, $region, $query));
	}

	public function getByDistrict(string $district, bool $expanded = FALSE): ResponseInterface
	{
		$query = $expanded
            ? '?' . Helpers::buildQuery(['expanded' => 'true'])
            : '';

		return $this->httpClient->request('GET', sprintf('%s/by-district/%s%s', self::BASE_URL, $district, $query));
	}

}
