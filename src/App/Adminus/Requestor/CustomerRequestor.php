<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\Client\CustomerClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class CustomerRequestor extends AbstractRequestor
{

	/** @var CustomerClient */
	private $client;

	public function __construct(CustomerClient $client)
	{
		$this->client = $client;
	}

	public function getAll(): ResponseInterface
	{
		return $this->client->getAll();
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		return $this->client->getById($id);
	}

	/**
	 * @param string|int $cardNumber
	 */
	public function getByCard($cardNumber): ResponseInterface
	{
		return $this->client->getByCard($cardNumber);
	}

	public function getByFilter(string $query): ResponseInterface
	{
		return $this->client->getByFilter($query);
	}

	/**
	 * @param string|int $interval Seconds count
	 */
	public function getByLastChange($interval): ResponseInterface
	{
		return $this->client->getByLastChange($interval);
	}

	/**
	 * @param string|int $from Unix timestamp
	 */
	public function getByLastChangeFrom($from): ResponseInterface
	{
		return $this->client->getByLastChangeFrom($from);
	}

	/**
	 * @param string|int $from
	 * @param string|int $to
	 */
	public function getByIdFromTo($from, $to): ResponseInterface
	{
		return $this->client->getByIdFromTo($from, $to);
	}

}
