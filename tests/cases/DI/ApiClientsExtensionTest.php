<?php declare(strict_types = 1);

namespace Tests\Cases\ISPA\ApiClients\DI;

use ISPA\ApiClients\App\Adminus\CrmClient;
use ISPA\ApiClients\App\Adminus\CrmRootquestor;
use ISPA\ApiClients\App\Adminus\Requestor\UserRequestor;
use ISPA\ApiClients\DI\ApiClientsExtension;
use ISPA\ApiClients\Domain\ApiClientLocator;
use ISPA\ApiClients\Domain\ApiManager;
use ISPA\ApiClients\Http\GuzzleAppFactory;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use PHPUnit\Framework\TestCase;

class ApiClientsExtensionTest extends TestCase
{

	public function testServicesRegistration(): void
	{
		$container = $this->createContainer();

		/** @var ApiManager $manager */
		$manager = $container->getByType(ApiManager::class);
		$this->assertInstanceOf(ApiManager::class, $manager);
		$this->assertInstanceOf(CrmRootquestor::class, $manager->crm);
		$this->assertInstanceOf(UserRequestor::class, $manager->crm->user);

		/** @var ApiClientLocator $locator */
		$locator = $container->getByType(ApiClientLocator::class);
		$this->assertInstanceOf(ApiClientLocator::class, $locator);
		$this->assertInstanceOf(CrmClient::class, $locator->crm);

		/** @var GuzzleAppFactory $guzzle */
		$guzzle = $container->getByType(GuzzleAppFactory::class);
		$this->assertInstanceOf(GuzzleAppFactory::class, $guzzle);
	}

	/**
	 * @param mixed[] $config
	 */
	private function createContainer(array $config = []): Container
	{
		$loader = new ContainerLoader(__DIR__ . '/../../tmp/' . getmypid(), TRUE);
		$class = $loader->load(function (Compiler $compiler) use ($config): void {
			$compiler->addConfig($config);
			$compiler->addExtension('ispa.apis', new ApiClientsExtension());
		}, serialize($config));

		/** @var Container $container */
		return new $class();
	}

}
