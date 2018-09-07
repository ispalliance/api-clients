<?php declare(strict_types = 1);

namespace ISPA\ApiClients\DI\Pass;

use ISPA\ApiClients\App\Pedef\Client\ThumbnailClient;
use ISPA\ApiClients\App\Pedef\PedefRootquestor;
use ISPA\ApiClients\App\Pedef\Requestor\ThumbnailRequestor;
use ISPA\ApiClients\DI\AppBuilder;

class AppPedefPass extends BaseAppPass
{

	/** @var mixed[] */
	protected $defaults = [
		'http' => [
			'baseUri' => '',
		],
	];

	public function loadPassConfiguration(): void
	{
		$app = 'pedef';

		// Is this APP enabled? (key in neon)
		if (!$this->isEnabled($app)) return;

		$this->validateConfig($app);

		$config = $this->getConfig($app);

		$builder = new AppBuilder($this->extension);

		// Http client
		$httpClient = $builder->addHttpClient($app, [
			'base_uri' => $config['http']['baseUri'],
		]);

		// Clients
		$thumbnailClient = $builder->addClient($app, 'thumbnail', ThumbnailClient::class, ['@' . $httpClient]);

		// Rootquestor
		$builder->addRootquestor($app, PedefRootquestor::class);

		// Requestors
		$builder->addRequestor($app, 'thumbnail', ThumbnailRequestor::class, ['@' . $thumbnailClient]);
	}

}
