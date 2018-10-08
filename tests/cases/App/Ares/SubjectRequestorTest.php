<?php declare(strict_types = 1);

namespace Tests\Cases\App\Ares;

use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Entity\Subject;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\TooManySubjectsException;
use ISPA\ApiClients\App\Ares\Requestor\SubjectRequestor;
use Tests\Cases\App\AbstractAppTestCase;

class SubjectRequestorTest extends AbstractAppTestCase
{

	public function testGetSuccess(): void
	{
		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_1.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		$subject = $subjectRequestor->get('27174824');

		$this->assertInstanceOf(Subject::class, $subject);
		$this->assertSame('Tlapnet s.r.o.', $subject->getName());
		$this->assertSame('27174824', $subject->getIdNumber());
		$this->assertSame('27174824', $subject->getVatIdNumber());
		$this->assertSame('Praha 9, Hrdlořezy, U schodů 122/5', $subject->getTextAddress());
	}

	public function testGetInvalidIdNumber(): void
	{
		$this->expectException(InvalidIdNumberException::class);

		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_0.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		$subjectRequestor->get('invalid_id_number');
	}

	public function testGetSubjectNotFound(): void
	{
		$this->expectException(SubjectNotFoundException::class);

		$httpClient    = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_0.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		// We want to check XML response so we must use right Identification Number to skip InvalidIdNumberException
		$subjectRequestor->get('27174824');
	}

	public function testGetAll0(): void
	{
		$httpClient       = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_0.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		$this->assertSame([], $subjectRequestor->getAll('Tlapnet'));
	}

	public function testGetAll4(): void
	{
		$httpClient       = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_4.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		$subjects = $subjectRequestor->getAll('Tlapnet');

		$this->assertTrue(is_array($subjects));
		$this->assertSame(4, count($subjects));

		foreach ($subjects as $subject) {
			$this->assertInstanceOf(Subject::class, $subject);
		}
	}

	public function testGetAllTooMany(): void
	{
		$this->expectException(TooManySubjectsException::class);

		$httpClient       = $this->createTestClient(200, file_get_contents(__DIR__ . '/files/subject_too_many.xml'));
		$subjectClient = new SubjectClient($httpClient);
		$subjectRequestor = new SubjectRequestor($subjectClient);

		$subjectRequestor->getAll('Tlapnet');
	}

}
