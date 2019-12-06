<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Crm\Requestor;

use ISPA\ApiClients\App\Adminus\Crm\Client\ContractClient;
use ISPA\ApiClients\App\Adminus\Crm\Utils\Filter;
use ISPA\ApiClients\App\Ispa\ResponseDataExtractor;
use ISPA\ApiClients\Domain\AbstractRequestor;

class ContractRequestor extends AbstractRequestor
{

	/** @var ContractClient */
	private $client;

	public function __construct(ContractClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @param string|int $id
	 * @param mixed[] $filters
	 * @return mixed[]
	 */
	public function getById($id, array $filters = []): array
	{
		$response = $this->client->getById($id);
		$this->assertResponse($response, [200, 404]);

		$item = ResponseDataExtractor::extractData($response);

		return Filter::isValid($item, $filters) ? $item : [];
	}

	/**
	 * @param string|int $contractNumber
	 * @return mixed[]
	 */
	public function getByContractNumber($contractNumber): array
	{
		$response = $this->client->getByContractNumber($contractNumber);
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param string|int $customerId
	 * @param mixed[] $filters
	 * @return mixed[]
	 */
	public function getByCustomer($customerId, array $filters = []): array
	{
		$response = $this->client->getByCustomer($customerId);
		$this->assertResponse($response, [200, 404]);

		$items = ResponseDataExtractor::extractData($response);

		return Filter::getValid($items, $filters);
	}

	/**
	 * @param string|int $cardNumber
	 * @return mixed[]
	 */
	public function getByCustomerCard($cardNumber): array
	{
		$response = $this->client->getByCustomerCard($cardNumber);
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param string|int $attributeSetId
	 * @return mixed[]
	 */
	public function getByAttributeSetId($attributeSetId): array
	{
		$response = $this->client->getByAttributeSetId($attributeSetId);
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @return mixed[]
	 */
	public function getOnlyActive(): array
	{
		$response = $this->client->getOnlyActive();
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param string|int $contractId
	 * @param string|int $stateId
	 * @return mixed[]
	 */
	public function setStateById($contractId, $stateId): array
	{
		$response = $this->client->setStateById($contractId, $stateId);
		$this->assertResponse($response);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param string|int $contractNumber
	 * @param string|int $stateId
	 * @return mixed[]
	 */
	public function setStateByContractNumber($contractNumber, $stateId): array
	{
		$response = $this->client->setStateByContractNumber($contractNumber, $stateId);
		$this->assertResponse($response);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @return mixed[]
	 */
	public function getAllContractTypeStates(): array
	{
		$response = $this->client->getAllContractTypeStates();
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

	/**
	 * @param string|int $id
	 * @return mixed[]
	 */
	public function getContractTypeStateById($id): array
	{
		$response = $this->client->getContractTypeStateById($id);
		$this->assertResponse($response, [200, 404]);

		return ResponseDataExtractor::extractData($response);
	}

}
