<?php declare(strict_types = 1);

namespace Tests\Cases\ISPA\ApiClients\Domain;

use GuzzleHttp\Client;
use ISPA\ApiClients\App\Adminus\CrmClient;
use ISPA\ApiClients\Domain\ApiClientLocator;
use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use PHPUnit\Framework\TestCase;

class ApiClientLocatorTest extends TestCase
{

	/** @var ApiClientLocator */
	private $locator;

	protected function setUp(): void
	{
		$this->locator = new ApiClientLocator();
	}

	public function testGet(): void
	{
		$crm = new CrmClient(new Client());
		$this->locator->add('crm', $crm);
		$this->assertSame($crm, $this->locator->crm);
	}

	public function testGetException(): void
	{
		$this->expectException(InvalidStateException::class);

		$this->locator->crm;
	}

}
