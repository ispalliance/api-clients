<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Requestor;

use ISPA\ApiClients\App\Dbd\Client\DebtorClient;
use ISPA\ApiClients\App\Dbd\Entity\Company;
use ISPA\ApiClients\App\Dbd\Entity\Person;
use ISPA\ApiClients\App\Dbd\Result\Result;
use ISPA\ApiClients\Domain\AbstractRequestor;

final class DebtorRequestor extends AbstractRequestor
{

	/** @var DebtorClient */
	private $client;

	public function __construct(DebtorClient $client)
	{
		$this->client = $client;
	}

	public function checkPerson(Person $person): Result
	{
		return new Result($person, $this->client->check($person));
	}

	public function checkCompany(Company $company): Result
	{
		return new Result($company, $this->client->check($company));
	}

}
