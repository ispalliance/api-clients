<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Client;

use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Utils\IdNumberUtils;
use ISPA\ApiClients\Domain\AbstractClient;
use Nette\Utils\Strings;
use Psr\Http\Message\ResponseInterface;

/**
 * @see https://wwwinfo.mfcr.cz/ares/ares_xml_es.html.cz
 */
class SubjectClient extends AbstractClient
{

	private const URL            = 'https://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi';
	private const URL_PARAMETERS = [
		'obch_jm' => null,
		'ico'     => null,
		'obec'    => '',
		'k_fu'    => '',
		'maxpoc'  => 200,
		'ulice'   => '',
		'cis_or'  => '',
		'cis_po'  => '',
		'setrid'  => 'ZADNE',
		'pr_for'  => '',
		'nace'    => '',
		'xml'     => 0,
		'filtr'   => 0, // 0 => All, 1 => Only active, 2 => Only inactive
		'jazyk'   => 'cz',
		'cestina' => '',
	];

	/**
	 * @throws InvalidIdNumberException
	 */
	public function get(string $idNumber): ResponseInterface
	{
		$idNumber = IdNumberUtils::normalize($idNumber);

		if (!IdNumberUtils::validate($idNumber)) {
			throw InvalidIdNumberException::create($idNumber);
		}

		$params        = self::URL_PARAMETERS;
		$params['ico'] = $idNumber;
		$url           = self::URL . '?' . http_build_query($params);

		return $this->client->request('GET', $url);
	}

	public function getAll(string $name): ResponseInterface
	{
		$params            = self::URL_PARAMETERS;
		$params['obch_jm'] = $this->normalizeName($name);
		$url               = self::URL . '?' . http_build_query($params);

		return $this->client->request('GET', $url);
	}

	private function normalizeName(string $name): string
	{
		$name = Strings::toAscii($name);
		$name = strtolower($name);
		$name = preg_replace('/[^a-z0-9]/', ' ', $name);
		$name = preg_replace('/\s{2,}/', ' ', $name);
		$name = trim($name);

		return $name;
	}

}
