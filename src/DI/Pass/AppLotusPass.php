<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Lotus\Client\UsersClient;
use ISPA\ApiClients\App\Lotus\LotusRootquestor;
use ISPA\ApiClients\App\Lotus\Requestor\UsersRequestor;
use ISPA\ApiClients\Http\GuzzleClient;

class AppLotusPass extends BaseAppPass
{

	/** @var mixed[] */
	protected $defaults = [
		'http' => [
			'baseUri' => '',
		],
	];

	public function loadPassConfiguration(): void
	{
		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled('lotus')) return;

		$this->validateConfig('lotus');

		$config = $this->getConfig('lotus');

		// Guzzle
		$guzzleConfig = [
			'base_uri' => $config['http']['baseUri'],
		];

		$this->extension->getContainerBuilder()
			->addDefinition($this->extension->prefix('app.lotus.guzzle.client'))
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [$guzzleConfig]);

		// Http client
		$this->extension->getContainerBuilder()
			->addDefinition($this->extension->prefix('app.lotus.http.client'))
			->setClass(GuzzleClient::class, [$this->extension->prefix('@app.lotus.guzzle.client')]);

		// Clients
		$this->extension->getContainerBuilder()
			->addDefinition($this->extension->prefix('app.lotus.client.users'))
			->setClass(UsersClient::class, [$this->extension->prefix('@app.lotus.http.client')]);

		// Rootquestor
		$this->extension->getContainerBuilder()
			->addDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->setClass(LotusRootquestor::class);

		$this->extension->getContainerBuilder()
			->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', ['lotus', $this->extension->prefix('@app.lotus.rootquestor')]);

		// Requestors
		$this->extension->getContainerBuilder()
			->addDefinition($this->extension->prefix('app.lotus.requestor.users'))
			->setClass(UsersRequestor::class, [$this->extension->prefix('@app.lotus.client.users')]);

		$this->extension->getContainerBuilder()
			->getDefinition($this->extension->prefix('app.lotus.rootquestor'))
			->addSetup('add', ['users', $this->extension->prefix('@app.lotus.requestor.users')]);
	}

}
