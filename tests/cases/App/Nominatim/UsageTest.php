<?php declare(strict_types = 1);

namespace Tests\Cases\App\Nominatim;

use ISPA\ApiClients\App\Nominatim\Client\AddressClient;
use ISPA\ApiClients\App\Nominatim\Requestor\AddressRequestor;
use ISPA\ApiClients\DI\Pass\AppNominatimPass;
use ISPA\ApiClients\Http\Guzzle\GuzzleClient;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use PHPUnit\Framework\TestCase;

final class UsageTest extends TestCase
{

	/** @var GuzzleClient */
	private $guzzle;

	public function setUp(): void
	{
		$this->markTestSkipped('Manual testing only');

		$config = [
			'app' => [
				AppNominatimPass::APP_NAME => [
					'http' => [
						'base_uri' => 'https://nominatim.openstreetmap.org',
					],
				],
			],
		];

		$this->guzzle = (new GuzzleFactory($config))->create(AppNominatimPass::APP_NAME);
	}

	public function testFindPlaceByCoords(): void
	{
		$client = new AddressClient($this->guzzle);
		$requestor = new AddressRequestor($client);

		$place = $requestor->findByCoords(50.4389786, 15.3510543);

		$this->assertNotNull($place);
		$this->assertEquals('20378588', $place->getId());
		$this->assertEquals(50.4389786, $place->getLat());
		$this->assertEquals(15.3510543, $place->getLng());
		$this->assertEquals(
			'35, Komenského náměstí, Jičín, okres Jičín, Královéhradecký kraj, Severovýchod, 50601, Česko',
			$place->getDisplayName()
		);

		$addr = $place->getAddress();
		$this->assertNotNull($addr);
		$this->assertEquals('35', $addr->getHouseNumber());
		$this->assertEquals('Komenského náměstí', $addr->getStreet());
		$this->assertEquals('Jičín', $addr->getSuburb());
	}

}
