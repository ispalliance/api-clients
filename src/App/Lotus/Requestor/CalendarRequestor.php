<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\CalendarClient;

/**
 * @property CalendarClient $client
 */
class CalendarRequestor extends BaseRequestor
{

	public function __construct(CalendarClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[] Data in ics format
	 */
	public function getFolder(int $id): array
	{
		$response = $this->client->getFolder($id);

		return $this->processResponse($response)->getData();
	}

}
