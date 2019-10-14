<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Nms\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class DeviceClient extends AbstractHttpClient
{

	public function getById(int $id): ResponseInterface
	{
		return $this->httpClient->request('GET', 'nms-lotus-detail/device-by-id/' . $id);
	}

	/**
	 * @param int[] $ids
	 * @return ResponseInterface[]
	 */
	public function getByIds(array $ids): array
	{
		$results = [];

		foreach ($ids as $id) {
			$results[] = $this->getById($id);
		}

		return $results;
	}

	public function findByQuery(string $query): ResponseInterface
	{
		return $this->httpClient->request('GET', 'nms-lotus-search/device-by-query/' . $query);
	}

}
