<?php declare(strict_types = 1);

namespace Tests\Cases\App\Ares;

use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use Tests\Cases\App\AbstractAppTestCase;

class AddressClientTest extends AbstractAppTestCase
{

	public function testInvalidIdNumber(): void
	{
		$this->expectException(InvalidIdNumberException::class);

		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/address_error.xml'));
		$addressClient = new AddressClient($httpClient);

		$addressClient->get('invalid_id_number');
	}

}
