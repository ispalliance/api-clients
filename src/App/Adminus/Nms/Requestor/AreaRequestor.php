<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Nms\Requestor;

use ISPA\ApiClients\App\Adminus\Nms\Client\AreaClient;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\Domain\AbstractRequestor;

class AreaRequestor extends AbstractRequestor
{

	/** @var AreaClient */
	private $client;

	public function __construct(AreaClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @return mixed[]
	 */
	public function getById(int $id): array
	{
		$response = $this->client->getById($id);

		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param int[] $ids
	 * @return mixed[]
	 */
	public function getByIds(array $ids): array
	{
		$results = [];

		foreach ($this->client->getByIds($ids) as $response) {
			$this->assertResponse($response, [200, 404]);

			$results[] = ResponseDataExtractor::extractData($response);
		}

		return $results;
	}

	/**
	 * @return mixed[]
	 */
	public function findByQuery(string $query): array
	{
		$response = $this->client->findByQuery($query);

		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

}
