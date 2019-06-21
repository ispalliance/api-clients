<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\JuicyPdf\Client\PdfClient;
use ISPA\ApiClients\App\JuicyPdf\JuicyPdfRootquestor;
use ISPA\ApiClients\App\JuicyPdf\Requestor\PdfRequestor;
use ISPA\ApiClients\Http\HttpClient;
use Nette\DI\ServiceDefinition;

class AppJuicyPdfPass extends BaseAppPass
{

	public const APP_NAME = 'juicypdf';

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

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
		$rootquestor = $builder->addDefinition($this->extension->prefix('app.juicypdf.rootquestor'))
			->setFactory(JuicyPdfRootquestor::class);

		// #4 -> #3 connect rootquestor to requestors
		$rootquestor
			->addSetup('add', ['pdf', $this->extension->prefix('@app.juicypdf.requestor.pdf')]);

		// ApiProvider -> #4 connect provider to rootquestor
		$provider = $builder->getDefinition($this->extension->prefix('provider'));
		assert($provider instanceof ServiceDefinition);
		$provider->addSetup('add', [self::APP_NAME, $this->extension->prefix('@app.juicypdf.rootquestor')]);
	}

}
