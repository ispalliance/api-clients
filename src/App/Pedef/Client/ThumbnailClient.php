<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class ThumbnailClient extends AbstractHttpClient
{

	public function generateThumbnail(string $contents, string $name = 'PDF file', string $fileName = 'file.pdf'): ResponseInterface
	{
		return $this->httpClient->request('POST', 'thumbnail', [
			'multipart' => [
				[
					'contents' => $contents,
					'filename' => $fileName,
					'name' => $name,
					'headers' => [
						'Content-Type' => 'application/pdf',
						'Content-Transfer-Encoding' => 'binary',
					],
				],
			],
			'timeout' => 10,
		]);
	}

}
