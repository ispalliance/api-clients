<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Pedef\Requestor;

use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\Domain\AbstractRequestor;

class ThumbnailRequestor extends AbstractRequestor
{

	/** @var ThumbnailClient */
	private $client;

	public function __construct(ThumbnailClient $client)
	{
		$this->client = $client;
	}

	public function generateThumbnail(string $contents, string $name = 'PDF file', string $fileName = 'file.pdf'): string
	{
		$response = $this->client->generateThumbnail($contents, $name, $fileName);

		$this->assertResponse($response);

		return $response->getBody()->getContents();
	}

}
