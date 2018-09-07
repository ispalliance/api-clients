<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI;

use ISPA\ApiClients\Exception\Logical\InvalidStateException;
use ISPA\ApiClients\Http\GuzzleClient;
use Nette\DI\ServiceDefinition;

class AppBuilder
{

	/** @var ApiClientsExtension */
	private $extension;

	/** @var ServiceDefinition|null */
	private $rootquestorDef;

	public function __construct(ApiClientsExtension $extension)
	{
		$this->extension = $extension;
	}

	/**
	 * @param mixed[] $guzzleConfig
	 */
	public function addHttpClient(string $app, array $guzzleConfig = []): string
	{
		$guzzleServiceName = $this->extension->prefix(sprintf('app.%s.guzzle.client', $app));

		$this->extension->getContainerBuilder()
			->addDefinition($guzzleServiceName)
			->setFactory($this->extension->prefix('@guzzleFactory::create'), [$guzzleConfig]);

		$clientServiceName = $this->extension->prefix(sprintf('app.%s.http.client', $app));

		$this->extension->getContainerBuilder()
			->addDefinition($clientServiceName)
			->setClass(GuzzleClient::class, ['@' . $guzzleServiceName]);

		return $clientServiceName;
	}

	/**
	 * @param mixed[] $args
	 */
	public function addClient(string $app, string $name, string $class, array $args = []): string
	{
		$serviceName = $this->extension->prefix(sprintf('app.%s.client.%s', $app, $name));

		$this->extension->getContainerBuilder()
			->addDefinition($serviceName)
			->setClass($class, $args);

		return $serviceName;
	}

	/**
	 * @param mixed[] $args
	 */
	public function addRootquestor(string $app, string $class, array $args = []): void
	{
		$serviceName = $this->extension->prefix(sprintf('app.%s.rootquestor', $app));

		$this->rootquestorDef = $this->extension->getContainerBuilder()
			->addDefinition($serviceName)
			->setClass($class, $args);

		$this->extension->getContainerBuilder()
			->getDefinition($this->extension->prefix('provider'))
			->addSetup('add', [$app, '@' . $serviceName]);
	}

	/**
	 * @param mixed[] $args
	 */
	public function addRequestor(string $app, string $name, string $class, array $args = []): void
	{
		if ($this->rootquestorDef === null) {
			throw new InvalidStateException(
				sprintf('Rootquestor for app "%s" is not registered. Register rootquestor first by calling method $this->>registerRootquestor($app).', $app)
			);
		}

		if (!$this->extension->getContainerBuilder()->hasDefinition($this->extension->prefix(sprintf('app.%s.client.%s', $app, $name)))) {
			throw new InvalidStateException(
				sprintf('Client "%s" service for app "%s" not found. Did you register the client with same name as requestor "%s"?', $name, $app, $name)
			);
		}

		$serviceName = $this->extension->prefix(sprintf('app.%s.requestor.%s', $app, $name));

		$this->extension->getContainerBuilder()
			->addDefinition($serviceName)
			->setClass($class, $args);

		$this->rootquestorDef->addSetup('add', [$name, '@' . $serviceName]);
	}

}
