<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Client;

use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Utils\IdNumberUtils;
use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

/**
 * @see https://wwwinfo.mfcr.cz/ares/ares_xml_standard.html.cz
 */
class AddressClient extends AbstractHttpClient
{

	private const URL = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi';

	/**
	 * @throws InvalidIdNumberException
	 */
	public function get(string $idNumber): ResponseInterface
	{
		$idNumber = IdNumberUtils::normalize($idNumber);

		if (!IdNumberUtils::validate($idNumber)) {
			throw InvalidIdNumberException::create($idNumber);
		}

		$params = [
			'typ_vyhledani' => 'ico',
			'ico' => $idNumber,
		];
		$url = self::URL . '?' . http_build_query($params);

		return $this->httpClient->request('GET', $url);
	}

}
