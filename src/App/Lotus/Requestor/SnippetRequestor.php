<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Requestor;

use ISPA\ApiClients\App\Lotus\Client\SnippetClient;

/**
 * @property SnippetClient $client
 */
class SnippetRequestor extends BaseRequestor
{

	public function __construct(SnippetClient $client)
	{
		parent::__construct($client);
	}

	/**
	 * @return mixed[]
	 */
	public function createSnippet(string $name, string $description, string $snippet): array
	{
		$response = $this->client->createSnippet($name, $description, $snippet);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function deleteSnippet(string $name): array
	{
		$response = $this->client->deleteSnippet($name);

		return $this->processResponse($response)->getData();
	}

}
