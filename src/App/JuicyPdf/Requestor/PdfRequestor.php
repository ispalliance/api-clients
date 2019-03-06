<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\JuicyPdf\Requestor;

use ISPA\ApiClients\App\JuicyPdf\Client\PdfClient;
use ISPA\ApiClients\Domain\AbstractRequestor;

final class PdfRequestor extends AbstractRequestor
{

	/** @var PdfClient */
	private $client;

	public function __construct(PdfClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param mixed[] $options
	 */
	public function fromSource(string $source, array $options = []): string
	{
		$response = $this->client->fromSource($source, $options);
		$response->getBody()->rewind();

		return $response->getBody()->getContents();
	}

}
