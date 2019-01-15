<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\Domain\AbstractRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class BaseRequestor extends AbstractRequestor
{

	private const STATUS_SUCCESS = 'success';

	/**
	 * @return mixed[]
	 */
	protected function getData(ResponseInterface $response): array
	{
		$this->assertResponse($response);

		$data = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);

		if (!isset($data['status'])) {
			throw new ResponseException($response, 'Missing "status" field in response data');
		}

		if ($data['status'] !== self::STATUS_SUCCESS) {
			throw new ResponseException($response, sprintf('API error: %s', $data['message'] ?? 'Unknown error'));
		}

		if (!isset($data['data'])) {
			throw new ResponseException($response, 'Missing "data" field in response data');
		}

		return $data['data'];
	}

}
