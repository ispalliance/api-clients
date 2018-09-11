<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use Psr\Http\Message\ResponseInterface;

class CustomerRequestor extends BaseRequestor
{

	public function getAll(): ResponseInterface
	{
		return $this->client->get('customer-detail/all');
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-id/%s', (string) $id));
	}

	/**
	 * @param string|int $cardNumber
	 */
	public function getByCard($cardNumber): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-card/%s', (string) $cardNumber));
	}

	public function getByFilter(string $query): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-filter/%s', $query));
	}

	/**
	 * @param string|int $interval Seconds count
	 */
	public function getByLastChange($interval): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-last-change/%s', (string) $interval));
	}

	/**
	 * @param string|int $from Unix timestamp
	 */
	public function getByLastChangeFrom($from): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-last-change-from/%s', (string) $from));
	}

	/**
	 * @param string|int $from
	 * @param string|int $to
	 */
	public function getByIdFromTo($from, $to): ResponseInterface
	{
		return $this->client->get(sprintf('customer-detail/by-id-from-to/%s/%s', (string) $from, (string) $to));
	}

}
