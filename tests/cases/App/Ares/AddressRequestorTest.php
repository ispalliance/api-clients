<?php declare(strict_types = 1);

namespace Tests\Cases\App\Ares;

use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Entity\Address;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
use ISPA\ApiClients\App\Ares\Requestor\AddressRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Tests\Cases\App\AbstractAppTestCase;

class AddressRequestorTest extends AbstractAppTestCase
{

	public function testSuccess(): void
	{
		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/address_success.xml'));
		$addressClient = new AddressClient($httpClient);
		$addressRequestor = new AddressRequestor($addressClient);

		$address = $addressRequestor->get('27174824');

		$this->assertInstanceOf(Address::class, $address);
		$this->assertSame('Tlapnet s.r.o.', $address->getName());
		$this->assertSame('U schodů', $address->getStreet());
		$this->assertSame('122', $address->getHouseNumber());
		$this->assertSame('5', $address->getOrientationNumber());
		$this->assertSame('Praha', $address->getCity());
		$this->assertSame('Hrdlořezy', $address->getCityPart());
		$this->assertSame('19000', $address->getPostcode());
	}

	public function testInvalidIdNumber(): void
	{
		$this->expectException(InvalidIdNumberException::class);

		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/address_error.xml'));
		$addressClient = new AddressClient($httpClient);
		$addressRequestor = new AddressRequestor($addressClient);

		$addressRequestor->get('invalid_id_number');
	}

	public function testNotFound(): void
	{
		$this->expectException(SubjectNotFoundException::class);

		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/address_not_found.xml'));
		$addressClient = new AddressClient($httpClient);
		$addressRequestor = new AddressRequestor($addressClient);

		// We want to check XML response so we must use right Identification Number to skip InvalidIdNumberException
		$addressRequestor->get('27174824');
	}

	public function testErrorResponse(): void
	{
		$this->expectException(ResponseException::class);
		$this->expectExceptionMessage('chyba logických vazeb vstupních dat v dotazu - POZOR! Hrozí zablokování Vaší IP adresy! Prosím čtěte http://wwwinfo.mfcr.cz/ares/ares_xml_standard.html.cz#max');

		$httpClient = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/address_error.xml'));
		$addressClient = new AddressClient($httpClient);
		$addressRequestor = new AddressRequestor($addressClient);

		// We want to check XML response so we must use right Identification Number to skip InvalidIdNumberException
		$addressRequestor->get('27174824');
	}

}
