<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\JuicyPdf\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use Psr\Http\Message\ResponseInterface;

class PdfClient extends AbstractHttpClient
{

	/**
	 * @param mixed[] $options
	 */
	public function fromSource(string $source, array $options = []): ResponseInterface
	{
		return $this->httpClient->request('POST', 'post/', [
			'json' => ['data' => $source],
			'query' => $options,
		]);
	}

}
