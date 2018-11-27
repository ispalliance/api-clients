<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\CPost\Requestor;

use DateTime;
use ISPA\ApiClients\App\CPost\Client\ConsignmentClient;
use ISPA\ApiClients\App\CPost\XmlRequest\Consignment\Consignment;
use ISPA\ApiClients\Domain\AbstractRequestor;
use ISPA\ApiClients\Exception\Logical\XmlException;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use ISPA\ApiClients\Utils\Xml\Helpers;
use Psr\Http\Message\ResponseInterface;

class ConsignmentRequestor extends AbstractRequestor
{

	/** @var ConsignmentClient */
	protected $client;

	public function __construct(ConsignmentClient $client)
	{
		$this->client = $client;
	}

	public function sendConsignment(Consignment $consignment): ResponseInterface
	{
		$response = $this->client->sendConsignment($consignment);

		$this->assertResponse($response);

		return $response;
	}

	public function getConsignmentsOverview(string $consignmentId): ResponseInterface
	{
		$response = $this->client->getConsignment($consignmentId);

		$this->assertResponse($response);

		return $response;
	}

	public function getConsignmentsByDate(DateTime $date): ResponseInterface
	{
		$response = $this->client->getConsignment(NULL, $date);

		$this->assertResponse($response);

		return $response;
	}

	/**
	 * @param int[] $allowedStatusCodes
	 */
	protected function assertResponse(ResponseInterface $response, array $allowedStatusCodes = [200]): void
	{
		parent::assertResponse($response, $allowedStatusCodes);

		$content = $response->getBody()->getContents();
		$response->getBody()->rewind();

		if (substr($content, 0, 36) !== '<?xml version="1.0" encoding="UTF-8"') {
			throw new ResponseException($response, 'Response does not contain valid XML string');
		}

		try {
			$data = Helpers::xmlToArray($content);
		} catch (XmlException $e) {
			throw new ResponseException(
				$response,
				sprintf('Could not convert xml response. Error: %s', $e->getMessage())
			);
		}

		if (
			isset($data['chyby']) &&
			isset($data['chyby']['@attributes']) &&
			array_key_exists('stav', $data['chyby']['@attributes']) &&
			intval($data['chyby']['@attributes']['stav']) !== 0
		) {
			throw new ResponseException(
				$response,
				sprintf('Response contains error code: %s', $data['chyby']['@attributes']['stav'])
			);
		}
	}

}
