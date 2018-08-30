<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Requestor;

use Psr\Http\Message\ResponseInterface;

class ThumbnailRequestor extends BaseRequestor
{

	public function generateThumbnail($pdfContents): ResponseInterface
	{
		return $this->client->post(
			'thumbnail',
			[
				'multipart' => [
					[
						'name' => 'PDF file',
						'filename' => "file.pdf",
						'contents' => $pdfContents,
						'headers' => [
							'Content-Type' => 'application/pdf',
							'Content-Transfer-Encoding' => "binary",
						],
					],
				],
			]
		);
	}

}
