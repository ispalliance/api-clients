<?php declare(strict_types = 1);

namespace Tests\Cases\ISPA\ApiClients\Domain;

use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\Domain\ApiManager;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use PHPUnit\Framework\TestCase;

class ApiManagerTest extends TestCase
{

	/** @var ApiManager */
	private $manager;

	protected function setUp(): void
	{
		$this->manager = new ApiManager();
	}

	public function testGet(): void
	{
		$crm = new CrmRootquestor();
		$this->manager->add('crm', $crm);
		$this->assertSame($crm, $this->manager->crm);
	}

	public function testGetException(): void
	{
		$this->expectException(InvalidStateException::class);

		$this->manager->crm;
	}

}
