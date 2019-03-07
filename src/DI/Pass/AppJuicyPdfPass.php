<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\JuicyPdf\Client\PdfClient;
use ISPA\ApiClients\App\JuicyPdf\JuicyPdfRootquestor;
use ISPA\ApiClients\App\JuicyPdf\Requestor\PdfRequestor;
use ISPA\ApiClients\Http\HttpClient;

class AppJuicyPdfPass extends BaseAppPass
{

	public const APP_NAME = 'juicypdf';

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled(self::APP_NAME)) return;

		$builder = $this->extension->getContainerBuilder();
		$this->validateConfig(self::APP_NAME);

		// #1 HTTP client
		$builder->addDefinition($this->extension->prefix('app.juicypdf.http.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [self::APP_NAME])
			->setType(HttpClient::class)
			->setAutowired(FALSE);

		// #2 Clients
		$builder->addDefinition($this->extension->prefix('app.juicypdf.client.pdf'))
			->setFactory(PdfClient::class, [$this->extension->prefix('@app.juicypdf.http.client')]);

		// #3 Requestors
		$builder->addDefinition($this->extension->prefix('app.juicypdf.requestor.pdf'))
			->setFactory(PdfRequestor::class, [$this->extension->prefix('@app.juicypdf.client.pdf')]);

		// #4 Rootquestor
		$builder->addDefinition($this->extension->prefix('app.juicypdf.rootquestor'))
			->setFactory(JuicyPdfRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$builder->getDefinition($this->extension->prefix('app.juicypdf.rootquestor'))
			->addSetup('add', ['pdf', $this->extension->prefix('@app.juicypdf.requestor.pdf')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$builder->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.juicypdf.rootquestor')]);
	}

}
