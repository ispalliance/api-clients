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
	public function deleteSnippet(int $id): array
	{
		$response = $this->client->deleteSnippet($id);

		return $this->processResponse($response)->getData();
	}

	/**
	 * @return mixed[]
	 */
	public function listSnippets(int $limit = 10, int $offset = 0): array
	{
		$response = $this->client->listSnippets($limit, $offset);

		return $this->processResponse($response)->getData();
	}

}
