<?php declare(strict_types = 1);

namespace Tests\ISPA\ApiClients\App\Ares;

use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use Tests\ISPA\ApiClients\App\AbstractAppTestCase;

class SubjectClientTest extends AbstractAppTestCase
{

	public function testGetInvalidIdNumber(): void
	{
		$this->expectException(InvalidIdNumberException::class);

		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/_fixtures/subject_0.xml'));
		$subjectClient = new SubjectClient($httpClient);

		$subjectClient->get('invalid_id_number');
	}

}
