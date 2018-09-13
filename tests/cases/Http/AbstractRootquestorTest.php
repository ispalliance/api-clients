<?php declare(strict_types = 1);

namespace Tests\Cases\ISPA\ApiClients\Http;

use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use ISPA\ApiClients\Http\AbstractRootquestor;
use ISPA\ApiClients\Http\Requestor\AbstractRequestor;
use PHPUnit\Framework\TestCase;

class AbstractRootquestorTest extends TestCase
{

	/** @var AbstractRootquestor */
	private $rootquestor;

	protected function setUp(): void
	{
		$this->rootquestor = new class extends AbstractRootquestor
		{

			public function add(string $name, AbstractRequestor $requestor): void
			{
				$this->addRequestor($name, $requestor);
			}

		};
	}

	public function testGet(): void
	{
		$requestor = new class extends AbstractRequestor
		{

		};
		$this->rootquestor->add('users', $requestor);

		$this->assertSame($requestor, $this->rootquestor->users);
	}

	public function testGetException(): void
	{
		$this->expectException(InvalidStateException::class);

		$this->rootquestor->users;
	}

}
