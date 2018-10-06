<?php declare(strict_types = 1);

namespace Tests\ISPA\ApiClients;

use GuzzleHttp\ClientInterface;
use ISPA\ApiClients as Api;
use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nette\DI\Extensions\ExtensionsExtension;
use PHPUnit\Framework\TestCase;

class NetteDITest extends TestCase
{

	private const TEMP_DIR = __DIR__ . '/_temp';

	/** @var Container */
	private $container;

	public static function setUpBeforeClass(): void
	{
		// todo: Better?
		// todo: Notify if dir exists
		self::deleteTemp();
	}

	public static function tearDownAfterClass(): void
	{
		self::deleteTemp();
	}

	public function testBaseServices(): void
	{
		$container = $this->getContainer();

		$this->assertInstanceOf(Api\Domain\ApiProvider::class, $container->getService('ispa.api.provider'));
		$this->assertInstanceOf(Api\Http\GuzzleFactory::class, $container->getService('ispa.api.guzzleFactory'));
	}

	/**
	 * @dataProvider appsProvider
	 * @param mixed[] $requestors
	 */
	public function testApp(string $name, string $rootquestorClass, array $requestors): void
	{
		$container = $this->getContainer();

		$this->assertInstanceOf(ClientInterface::class, $container->getService(sprintf('ispa.api.app.%s.guzzle.client', $name)));
		$this->assertInstanceOf(Api\Http\GuzzleClient::class, $container->getService(sprintf('ispa.api.app.%s.http.client', $name)));

		/** @var Api\Domain\ApiProvider $api */
		$api = $container->getService('ispa.api.provider');

		$this->assertInstanceOf($rootquestorClass, $container->getService(sprintf('ispa.api.app.%s.rootquestor', $name)));
		$this->assertInstanceOf($rootquestorClass, $api->$name);

		foreach ($requestors as $requestorName => $classes) {
			$this->assertInstanceOf($classes[0], $container->getService(sprintf('ispa.api.app.%s.client.%s', $name, $requestorName)));
			$this->assertInstanceOf($classes[1], $container->getService(sprintf('ispa.api.app.%s.requestor.%s', $name, $requestorName)));
			$this->assertInstanceOf($classes[1], $api->$name->$requestorName);
		}
	}

	/**
	 * @return mixed[]
	 */
	public function appsProvider(): array
	{
//			[
//				'app_name',
//				'rootquestor_class',
//				[
//					'requestor_name' => ['client_class', 'requestor_class'],
//				]
//			],
		return [
			[
				'crm',
				Api\App\Adminus\CrmRootquestor::class,
				[
					'accountingEntity' => [Api\App\Adminus\Client\AccountingEntityClient::class, Api\App\Adminus\Requestor\AccountingEntityRequestor::class],
					'contract' => [Api\App\Adminus\Client\ContractClient::class, Api\App\Adminus\Requestor\ContractRequestor::class],
					'customer' => [Api\App\Adminus\Client\CustomerClient::class, Api\App\Adminus\Requestor\CustomerRequestor::class],
					'user' => [Api\App\Adminus\Client\UserClient::class, Api\App\Adminus\Requestor\UserRequestor::class],
				],
			],
			[
				'ares',
				Api\App\Ares\AresRootquestor::class,
				[
					'address' => [Api\App\Ares\Client\AddressClient::class, Api\App\Ares\Requestor\AddressRequestor::class],
					'subject' => [Api\App\Ares\Client\SubjectClient::class, Api\App\Ares\Requestor\SubjectRequestor::class],
				],
			],
			[
				'lotus',
				Api\App\Lotus\LotusRootquestor::class,
				[
					'users' => [Api\App\Lotus\Client\UsersClient::class, Api\App\Lotus\Requestor\UsersRequestor::class],
				],
			],
			[
				'pedef',
				Api\App\Pedef\PedefRootquestor::class,
				[
					'thumbnail' => [Api\App\Pedef\Client\ThumbnailClient::class, Api\App\Pedef\Requestor\ThumbnailRequestor::class],
				],
			],
		];
	}

	private function getContainer(): Container
	{
		if ($this->container === NULL) {
			$loader          = new ContainerLoader(self::TEMP_DIR, TRUE);
			$class           = $loader->load(function (Compiler $compiler): void {
				$compiler->addExtension('extensions', new ExtensionsExtension());
				$compiler->loadConfig(__DIR__ . '/_fixtures/config.neon');
			});
			$this->container = new $class();
		}

		return $this->container;
	}

	private static function deleteTemp(): void
	{
		if (is_dir(self::TEMP_DIR)) {
			foreach (scandir(self::TEMP_DIR) as $item) {
				if ($item[0] === '.') {
					continue;
				}

				unlink(self::TEMP_DIR . '/' . $item);
			}

			rmdir(self::TEMP_DIR);
		}

		if (file_exists(self::TEMP_DIR)) {
			throw new Api\Exception\Logical\InvalidStateException(sprintf('Nette DI temp dir "%s" still exists.', self::TEMP_DIR));
		}
	}

}
