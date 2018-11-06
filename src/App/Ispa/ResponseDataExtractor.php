<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ispa;

use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

final class ResponseDataExtractor
{

	/**
	 * @return mixed[]
	 */
	public static function extractData(ResponseInterface $response): array
	{
		if ($response->getStatusCode() === 404) {
			return [];
		}

		$data = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);

		if (
			!array_key_exists('success', $data) ||
			!array_key_exists('data', $data)
		) {
			throw new InvalidStateException('Response content lacks mandatory fields.');
		}

		if ($data['success'] !== TRUE) {
			throw new InvalidStateException('Response content contains falsy status.');
		}

		return $data['data'];
	}

}
