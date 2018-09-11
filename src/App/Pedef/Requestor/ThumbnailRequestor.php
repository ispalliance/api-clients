<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Requestor;

use Psr\Http\Message\ResponseInterface;

class ThumbnailRequestor extends BaseRequestor
{

	public function generateThumbnail(
		string $contents,
		string $name = 'PDF file',
		string $fileName = 'file.pdf'
	): ResponseInterface
	{
		return $this->client->post(
			'thumbnail',
			[
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
			]
		);
	}

}
