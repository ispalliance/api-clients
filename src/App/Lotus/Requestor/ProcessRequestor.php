<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\ProcessClient;

final class ProcessRequestor extends BaseRequestor
{

	/** @var ProcessClient */
	private $client;

	public function __construct(ProcessClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @return mixed[]
	 */
	public function listProcesses(int $limit = 10, int $offset = 0): array
	{
		$response = $this->client->listProcesses($limit, $offset);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function getProcess(int $id): array
	{
		$response = $this->client->getProcess($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function listTemplates(int $limit = 10, int $offset = 0): array
	{
		$response = $this->client->listTemplates($limit, $offset);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function getTemplate(int $id): array
	{
		$response = $this->client->getTemplate($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @param mixed[] $data
	 * @return mixed[]
	 */
	public function startProcess(int $id, array $data): array
	{
		$response = $this->client->startProcess($id, $data);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function uploadFile(
		int $processId,
		string $variable,
		string $fileName,
		string $contents
	): array
	{
		$response = $this->client->uploadFile($processId, $variable, $fileName, $contents);

		return $this->processResponse($response)->getData();
	}

}
