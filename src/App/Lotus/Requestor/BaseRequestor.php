<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\AbstractLotusClient;
use ISPA\ApiClients\App\Lotus\Entity\LotusResponse;
use ISPA\ApiClients\Domain\AbstractRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;

class BaseRequestor extends AbstractRequestor
{

	/** @var AbstractLotusClient */
	protected $client;

	public function __construct(AbstractLotusClient $client)
	{
		$this->client = $client;
	}

	public function enableSudo(string $email): void
	{
		$this->client->enableSudo($email);
	}

	public function disableSudo(): void
	{
		$this->client->disableSudo();
	}

	public function isSudo(): bool
	{
		return $this->client->isSudo();
	}

	protected function processResponse(ResponseInterface $response): LotusResponse
	{
		$this->assertResponse($response);

		try {
			$resp = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
		} catch (JsonException $e) {
			throw new ResponseException($response, 'Response is not valid JSON.');
		}

		if (!isset($resp['status'])) {
			throw new ResponseException($response, 'Missing "status" field in response data');
		}

		$lotusResp = new LotusResponse(
			$resp['status'],
			$resp['data'] ?? NULL,
			$resp['code'] ?? NULL,
			$resp['message'] ?? NULL,
			$resp['context'] ?? NULL
		);

		if (!$lotusResp->isSuccess()) {
			throw new ResponseException(
				$response,
				sprintf('API error. Status: %s, Message: %s', $lotusResp->getStatus(), $lotusResp->getMessage())
			);
		}

		return $lotusResp;
	}

}
