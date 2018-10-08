<?php declare(strict_types = 1);

namespace Tests\Cases\App\Pedef;

use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use Tests\Cases\App\AbstractAppTestCase;

class ThumbnailRequestorTest extends AbstractAppTestCase
{

	public function testUserRequestor(): void
	{
		$httpClient         = $this->createTestClient(200, 'PDF');
		$thumbnailClient    = new ThumbnailClient($httpClient);
		$thumbnailRequestor = new ThumbnailRequestor($thumbnailClient);

		$res = $thumbnailRequestor->generateThumbnail('Hello');
		$this->assertTrue(is_string($res));
		$this->assertEquals('PDF', $res);
	}

}
