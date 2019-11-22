<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class CustomerFileClient extends AbstractHttpClient
{

	public const PREFIX = 'customer-file';

	public function getAll(): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/all', self::PREFIX));
	}

	public function getByCustomer(int $id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/by-customer/%s', self::PREFIX, strval($id)));
	}

	public function download(int $customerId, int $fileId): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/download/%s/%s', self::PREFIX, strval($customerId), strval($fileId)));
	}

	/**
	 * @param mixed[] $data
	 */
	public function update(int $fileId, array $data): ResponseInterface
	{
		return $this->httpClient->request('PUT', sprintf('%s/%s', self::PREFIX, strval($fileId)), [
			'json' => $data,
		]);
	}

	public function uploadFile(int $customerId, string $fileName, string $contents): ResponseInterface
	{
		return $this->httpClient->request('POST', sprintf('%s/upload/%s', self::PREFIX, strval($customerId)), [
			'multipart' => [
				[
					'name' => 'File',
					'filename' => $fileName,
					'contents' => $contents,
				],
			],
		]);
	}

	public function delete(int $fileId): ResponseInterface
	{
		return $this->httpClient->request('DELETE', sprintf('%s/remove-file/%s', self::PREFIX, strval($fileId)));
	}

}
