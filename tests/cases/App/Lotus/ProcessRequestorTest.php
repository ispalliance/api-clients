<?php declare(strict_types = 1);

namespace Tests\Cases\App\Lotus;

use ISPA\ApiClients\App\Lotus\Client\ProcessClient;
use ISPA\ApiClients\App\Lotus\Requestor\ProcessRequestor;
use Tests\Cases\App\AbstractAppTestCase;

class ProcessRequestorTest extends AbstractAppTestCase
{

	public function testListProcesses(): void
	{
		$requestor = $this->createRequestor('processes.json');
		$res = $requestor->listProcesses();

		$this->assertCount(10, $res);
	}

	public function testGetProcess(): void
	{
		$requestor = $this->createRequestor('process.json');
		$res = $requestor->getProcess(1);

		$this->assertEquals('Úkol', $res['name']);
		$this->assertEquals(1, $res['template']['id']);
		$this->assertEquals('Zadání úkolu', $res['current_step']['name']);
		$this->assertCount(9, $res['steps']);
	}

	public function testListTemplates(): void
	{
		$requestor = $this->createRequestor('templates.json');
		$res = $requestor->listTemplates();

		$this->assertCount(4, $res);
	}

	public function testGetTemplate(): void
	{
		$requestor = $this->createRequestor('template.json');
		$res = $requestor->getTemplate(2);

		$this->assertEquals('Mereni casu ala toggle', $res['name']);
		$this->assertEquals('Mereni casu ala toggle', $res['description']);
		$this->assertEquals(3, $res['creator']);
		$this->assertEquals(3, $res['steps']);
		$this->assertEquals('2019-01-14T08:44:54+01:00', $res['created_at']);
	}

	public function testStartProcess(): void
	{
		$requestor = $this->createRequestor('process.json');
		$res = $requestor->startProcess(1);

		$this->assertEquals('Úkol', $res['name']);
	}

	private function createRequestor(string $file): ProcessRequestor
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/data/' . $file));
		$client = new ProcessClient($httpClient);

		return new ProcessRequestor($client);
	}

}
