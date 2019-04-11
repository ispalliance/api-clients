<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractLotusClient
{

	private const PATH_PROCESS = 'processes';
	private const PATH_TEMPLATE = 'template-processes';
	private const PATH_START = 'start-process';
	private const PATH_UPLOAD = 'process/%s/upload?variable=%s';

	public function listProcesses(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH_PROCESS, $query));
	}

	/**
	 * @param mixed[] $variables
	 */
	public function listProcessesByVariables(array $variables): ResponseInterface
	{
		return $this->httpClient->request(
			'POST',
			sprintf('%s/find-by-variables', self::PATH_PROCESS),
			[
				'body' => Json::encode($variables),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function getProcess(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/detail/%d', self::PATH_PROCESS, $id));
	}

	public function addTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('POST', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function removeTag(int $pid, int $ttid): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%d/tags/%d', self::PATH_PROCESS, $pid, $ttid));
	}

	public function listTemplates(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH_TEMPLATE, $query));
	}

	public function listStartableTemplates(): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/startable', self::PATH_TEMPLATE));
	}

	public function getTemplate(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/detail/%d', self::PATH_TEMPLATE, $id));
	}

	/**
	 * @param mixed[] $data
	 */
	public function startProcess(int $id, ?array $data = []): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%d', self::PATH_START, $id),
			[
				'body' => Json::encode($data),
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
			sprintf(self::PATH_UPLOAD, $processId, $variable),
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

}
