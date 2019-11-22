<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Requestor;

use ISPA\ApiClients\App\Adminus\Crm\Client\CustomerFileClient;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class CustomerFileRequestor extends AbstractRequestor
{

	/** @var CustomerFileClient */
	private $client;

	public function __construct(CustomerFileClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @return mixed[]
	 */
	public function getAll(): array
	{
		return $this->getResponseArrayData($this->client->getAll(), [200, 404]);
	}

	/**
	 * @return mixed[]
	 */
	public function getByCustomer(int $id): array
	{
		return $this->getResponseArrayData($this->client->getByCustomer($id), [200, 404]);
	}

	/**
	 * @return mixed[]
	 */
	public function download(int $customerId, int $fileId): array
	{
		return $this->getResponseArrayData($this->client->download($customerId, $fileId), [200, 404]);
	}

	/**
	 * @return mixed[]
	 */
	public function uploadFile(int $id, string $fileName, string $contents): array
	{
		return $this->getResponseArrayData($this->client->uploadFile($id, $fileName, $contents), [200, 400, 404]);
	}

	/**
	 * @param mixed[] $data
	 */
	public function update(int $fileId, array $data): int
	{
		return $this->getResponseIntegerData($this->client->update($fileId, $data), [200, 400, 404]);
	}

	public function delete(int $fileId): bool
	{
		return $this->getResponseBooleanData($this->client->delete($fileId), [200, 400, 404]);
	}

	/**
	 * @param int[] $allowedstatusCodes
	 * @return mixed[]
	 */
	private function getResponseArrayData(ResponseInterface $response, array $allowedstatusCodes): array
	{
		$this->assertResponse($response, $allowedstatusCodes);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param int[] $allowedstatusCodes
	 */
	private function getResponseBooleanData(ResponseInterface $response, array $allowedstatusCodes): bool
	{
		$this->assertResponse($response, $allowedstatusCodes);

		return ResponseDataExtractor::extractBooleanData($response);
	}

	/**
	 * @param int[] $allowedstatusCodes
	 */
	private function getResponseIntegerData(ResponseInterface $response, array $allowedstatusCodes): int
	{
		$this->assertResponse($response, $allowedstatusCodes);

		return ResponseDataExtractor::extractIntegerData($response);
	}

}
