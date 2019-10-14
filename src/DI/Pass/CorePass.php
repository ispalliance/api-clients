<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\Domain\ApiProvider;
use ISPA\ApiClients\Http\Guzzle\GuzzleFactory;
use ISPA\ApiClients\Http\Soaper\SoaperFactory;
use ISPA\ApiClients\Utils\Arrays;

class CorePass extends AbstractPass
{

	public const APP_NAME = 'core';

	private const APP_GUZZLE = [
		AppAresPass::APP_NAME,
		AppAdminusCrmPass::APP_NAME,
		AppLotusPass::APP_NAME,
		AppPedefPass::APP_NAME,
		AppRuianPass::APP_NAME,
	];

	private const APP_SOAP = [
		AppDbdPass::APP_NAME,
	];

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		$builder->addDefinition($this->extension->prefix('provider'))
			->setFactory(ApiProvider::class);

		$this->loadGuzzleConfiguration();
		$this->loadSoapConfiguration();
	}

	private function loadGuzzleConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig();

		// Is Guzzle needed?
		if (!Arrays::containsKey($config['app'], self::APP_GUZZLE)) return;

		$builder->addDefinition($this->extension->prefix('guzzleFactory'))
			->setFactory(GuzzleFactory::class, [$config]);
	}

	private function loadSoapConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig();

		// Is SOAP needed?
		if (!Arrays::containsKey($config['app'], self::APP_SOAP)) return;

		$builder->addDefinition($this->extension->prefix('soapFactory'))
			->setFactory(SoaperFactory::class, [$config]);
	}

}
