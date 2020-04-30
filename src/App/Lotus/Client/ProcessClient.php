<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\App\Lotus\Filter\ProcessListFilter;
use ISPA\ApiClients\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractLotusClient
{

	private const PATH_PROCESS = 'processes';
	private const PATH_TEMPLATE = 'template-processes';

	/**
	 * @param string[] $include
	 */
	public function listProcesses(int $limit = 10, int $offset = 0, ?ProcessListFilter $filter = NULL, array $include = []): ResponseInterface
	{
		$parameters = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'include' => implode(',', $include),
		];

		if ($filter !== NULL) {
			$state = $filter->getState();
			if ($state !== NULL) {
				$parameters['state'] = $state;
			}

			$creatorId = $filter->getCreatorId();
			if ($creatorId !== NULL) {
				$parameters['creatorId'] = $creatorId;
			}

			$possibleResolverId = $filter->getPossibleResolverId();
			if ($possibleResolverId !== NULL) {
				$parameters['possibleResolverId'] = $possibleResolverId;
			}

			$variables = $filter->getVariables();
			if ($variables !== NULL) {
				$parameters['variables'] = Json::encode($variables);
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH_PROCESS, Helpers::buildQuery($parameters)));
	}

	/**
	 * @param string[] $include
	 */
	public function getProcess(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH_PROCESS, $id, $query));
	}

	public function addTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function removeTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function moveProcessToNextStep(int $processId): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%s/next', self::PATH_PROCESS, $processId),
			[
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function uploadFile(
		int $processId,
		string $variable,
		string $fileName,
		string $contents
	): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%s/upload?variable=%s', self::PATH_PROCESS, $processId, $variable),
			[
				'multipart' => [
					[
						'name' => 'File',
						'filename' => $fileName,
						'contents' => $contents,
					],
				],
			]
		);
	}

	/**
	 * @param mixed[] $data
	 * @param string[] $include
	 */
	public function startProcess(int $tid, array $data = [], array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request(
			'POST',
			sprintf('%s/%s/start-process?%s', self::PATH_TEMPLATE, $tid, $query),
			[
				'body' => Json::encode($data),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	/**
	 * @param string[] $include
	 */
	public function listTemplates(int $limit = 10, int $offset = 0, bool $startableOnly = FALSE, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
			'startableOnly' => $startableOnly ? 'true' : 'false',
			'include' => implode(',', $include),
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH_TEMPLATE, $query));
	}

	/**
	 * @param string[] $include
	 */
	public function getTemplate(int $id, array $include = []): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'include' => implode(',', $include),
		]);

		return $this->request('GET', sprintf('%s/%d?%s', self::PATH_TEMPLATE, $id, $query));
	}

	public function createTemplate(string $template): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH_TEMPLATE),
			[
				'body' => Json::encode([
					'template' => $template,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteTemplate(int $templateId): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH_TEMPLATE, $templateId));
	}

	public function archiveTemplate(int $templateId): ResponseInterface
	{
		return $this->request('PATCH', sprintf('%s/%s/archive', self::PATH_TEMPLATE, $templateId));
	}

}
