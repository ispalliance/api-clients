<?php declare(strict_types = 1);

namespace Tests\Cases\App\JuicyPdf;

use Contributte\Utils\FileSystem;
use ISPA\ApiClients\App\JuicyPdf\Client\PdfClient;
use ISPA\ApiClients\App\JuicyPdf\Requestor\PdfRequestor;
use ISPA\ApiClients\Http\Guzzle\GuzzleClient;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use Tests\Toolkit\TestCase;

final class UsageTest extends TestCase
{

	/** @var GuzzleClient */
	private $guzzle;

	public function setUp(): void
	{
		$config = [
			'app' => [
				'juicypdf' => [
					'http' => [
						'base_uri' => 'https://pdf.jfx.cz/',
					],
				],
			],
		];

		$this->guzzle = (new GuzzleFactory($config))->create('juicypdf');
	}

	public function testFromSource(): void
	{
		$pdfClient = new PdfClient($this->guzzle);
		$pdfRequestor = new PdfRequestor($pdfClient);

		$file = $pdfRequestor->fromSource('Hello');
		FileSystem::write(self::TEMP_DIR . '/file-a4.pdf', $file);
		$this->assertNotEmpty($file);

		$file = $pdfRequestor->fromSource('Hello', ['format' => 'A3']);
		FileSystem::write(self::TEMP_DIR . '/file-a3.pdf', $file);
		$this->assertNotEmpty($file);
	}

}
