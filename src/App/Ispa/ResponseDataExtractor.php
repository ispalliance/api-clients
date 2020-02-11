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

		$data = self::extractResponse($response);

		return (array) $data['data'];
	}

	public static function extractBooleanData(ResponseInterface $response): bool
	{
		if ($response->getStatusCode() === 404) {
			return FALSE;
		}

		$data = self::extractResponse($response);

		return $data['data'];
	}

	public static function extractIntegerData(ResponseInterface $response): int
	{
		if ($response->getStatusCode() === 404) {
			return 0;
		}

		$data = self::extractResponse($response);

		return $data['data'];
	}

	/**
	 * @return mixed[]
	 */
	private static function extractResponse(ResponseInterface $response): array
	{
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

		return $data;
	}

}
