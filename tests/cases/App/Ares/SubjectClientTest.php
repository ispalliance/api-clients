<?php declare(strict_types = 1);

namespace Tests\Cases\App\Ares;

use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use Tests\Cases\App\AbstractAppTestCase;

class SubjectClientTest extends AbstractAppTestCase
{

	public function testGetInvalidIdNumber(): void
	{
		$this->expectException(InvalidIdNumberException::class);

		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_0.xml'));
		$subjectClient = new SubjectClient($httpClient);

		$subjectClient->get('invalid_id_number');
	}

}
