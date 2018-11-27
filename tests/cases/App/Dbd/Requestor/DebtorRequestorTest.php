<?php declare(strict_types = 1);

namespace Tests\Cases\App\Dbd\Requestor;

use Contributte\Utils\FileSystem;
use ISPA\ApiClients\App\Dbd\Client\DebtorClient;
use ISPA\ApiClients\App\Dbd\Entity\Person;
use ISPA\ApiClients\App\Dbd\Entity\TestPerson;
use ISPA\ApiClients\App\Dbd\Requestor\DebtorRequestor;
use ISPA\ApiClients\App\Dbd\Result\Result;
use ISPA\ApiClients\Http\Soaper\SoaperFactory;
use PHPUnit\Framework\TestCase;

final class DebtorRequestorTest extends TestCase
{

	private const EXAMPLE_RESPONSE = __DIR__ . '/result.xml';

	/** @var mixed[] */
	private $config = [];

	public function setUp(): void
	{
		$this->config = [
			'http' => [
				'wsdl' => 'http://ws.dcgroup.cz/index.php?WSDL',
				'auth' => [
					'user' => 'fill real user',
					'pass' => 'fill real pass',
				],
			],
			'config' => [
				'test' => TRUE, // enable test mode in order not to be charged for api calls
			],
		];
	}

	public function testCheckPerson(): void
	{
		$this->markTestSkipped('Manual testing only');

		$config = ['app' => ['dbd_test' => $this->config]];
		$factory = new SoaperFactory($config);
		$soap = $factory->create('dbd_test');
		$debtorClient = new DebtorClient($soap, $this->config);
		$requestor = new DebtorRequestor($debtorClient);

		$person = TestPerson::get();
		$result = $requestor->checkPerson($person);

		$this->assertInstanceOf(Result::class, $result);
		$this->assertEquals(FileSystem::read(self::EXAMPLE_RESPONSE), $result->toArray()['xml']);
	}

	public function testCheckPersonMockedCall(): void
	{
		$xml = simplexml_load_file(self::EXAMPLE_RESPONSE);
		$debtorClient = $this->createMock(DebtorClient::class);
		$debtorClient->method('check')->willReturn($xml);

		$requestor = new DebtorRequestor($debtorClient);

		$person = TestPerson::get();
		$result = $requestor->checkPerson($person);

		$this->assertInstanceOf(Result::class, $result);
		$this->assertInstanceOf(Person::class, $result->getSubject());
		$this->assertEquals($person->getBirthDate(), $result->getSubject()->getBirthDate());

		$this->assertCount(8, $result->getCeeResults());
		$this->assertEquals('094EX07393/09', $result->getCeeResults()[0]->ceeId);
		$this->assertEquals('085EX594/14', $result->getCeeResults()[7]->ceeId);

		$this->assertCount(1, $result->getInsolventResult());
		$this->assertEquals('test/001/2017', $result->getInsolventResult()[0]->insolventId);

		$this->assertEmpty($result->getDebtResults());

		$this->assertTrue($result->isDebtor());
	}

}
