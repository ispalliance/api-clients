<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Filter\ProcessListFilter;

/**
 * @property ProcessClient $client
 */
final class ProcessRequestor extends BaseRequestor
{

	public function __construct(ProcessClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function listProcesses(int $limit = 10, int $offset = 0, ?ProcessListFilter $filter = NULL): array
	{
		$response = $this->client->listProcesses($limit, $offset, $filter);

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
	public function addTag(int $pid, int $ttid): array
	{
		$response = $this->client->addTag($pid, $ttid);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function removeTag(int $pid, int $ttid): array
	{
		$response = $this->client->removeTag($pid, $ttid);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function moveProcessToNextStep(int $processId): array
	{
		$response = $this->client->moveProcessToNextStep($processId);

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

	/**
	 * @param mixed[] $data
	 * @return mixed[]
	 */
	public function startProcess(int $tid, array $data = []): array
	{
		$response = $this->client->startProcess($tid, $data);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function listTemplates(int $limit = 10, int $offset = 0, bool $startableOnly = FALSE): array
	{
		$response = $this->client->listTemplates($limit, $offset, $startableOnly);

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
	 * @return mixed[]
	 */
	public function createTemplate(string $template): array
	{
		$response = $this->client->createTemplate($template);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteTemplate(int $templateId): array
	{
		$response = $this->client->deleteTemplate($templateId);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function archiveTemplate(int $templateId): array
	{
		$response = $this->client->archiveTemplate($templateId);

		return $this->processResponse($response)->getData();
	}

}
