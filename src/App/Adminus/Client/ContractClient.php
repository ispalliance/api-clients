<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Client;

use ISPA\ApiClients\Domain\AbstractClient;
use Psr\Http\Message\ResponseInterface;

class ContractClient extends AbstractClient
{

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-detail/by-id/%s', (string) $id));
	}

	/**
	 * @param string|int $contractNumber
	 */
	public function getByContractNumber($contractNumber): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-detail/by-contract-number/%s', (string) $contractNumber));
	}

	/**
	 * @param string|int $customerId
	 */
	public function getByCustomer($customerId): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-detail/by-customer/%s', (string) $customerId));
	}

	/**
	 * @param string|int $cardNumber
	 */
	public function getByCustomerCard($cardNumber): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-detail/by-customer-card/%s', (string) $cardNumber));
	}

	/**
	 * @param string|int $attributeSetId
	 */
	public function getByAttributeSetId($attributeSetId): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-detail/by-attribute-set-id/%s', (string) $attributeSetId));
	}

	public function getOnlyActive(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'contract-detail/only-active');
	}

	/**
	 * @param string|int $contractId
	 * @param string|int $stateId
	 */
	public function setStateById($contractId, $stateId): ResponseInterface
	{
		return $this->httpClient->request('PUT', sprintf('contract-detail/set-state/%s/%s', (string) $contractId, (string) $stateId));
	}

	/**
	 * @param string|int $contractNumber
	 * @param string|int $stateId
	 */
	public function setStateByContractNumber($contractNumber, $stateId): ResponseInterface
	{
		return $this->httpClient->request('PUT', sprintf('contract-detail/set-state-by-contract-number/%s/%s', (string) $contractNumber, (string) $stateId));
	}

	public function getAllContractTypeStates(): ResponseInterface
	{
		return $this->httpClient->request('GET', 'contract-type-state');
	}

	/**
	 * @param string|int $id
	 */
	public function getContractTypeStateById($id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('contract-type-state/%s', $id));
	}

}
