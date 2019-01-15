<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class ProcessClient extends AbstractHttpClient
{

	private const PATH_PROCESS = 'processes';
	private const PATH_TEMPLATE = 'template-processes';
	private const PATH_START = 'start-process';

	public function listProcesses(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit,
			'offset' => $offset,
		]);
		return $this->httpClient->request('GET', sprintf('%s?%s', self::PATH_PROCESS, $query));
	}

	public function getProcess(int $id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/%d', self::PATH_PROCESS, $id));
	}

	public function listTemplates(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit,
			'offset' => $offset,
		]);
		return $this->httpClient->request('GET', sprintf('%s?%s', self::PATH_TEMPLATE, $query));
	}

	public function getTemplate(int $id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/%d', self::PATH_TEMPLATE, $id));
	}

	/**
	 * @param mixed[] $data
	 */
	public function startProcess(int $id, array $data): ResponseInterface
	{
		return $this->httpClient->request('POST', sprintf('%s/%d', self::PATH_START, $id), ['form_params' => $data]);
	}

}
