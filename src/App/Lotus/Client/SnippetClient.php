<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class SnippetClient extends AbstractLotusClient
{

	private const PATH = 'snippets';

	public function createSnippet(string $name, string $description, string $snippet): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s/%s', self::PATH, $name),
			[
				'body' => Json::encode([
					'description' => $description,
					'snippet' => $snippet,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function deleteSnippet(string $name): ResponseInterface
	{
		return $this->request('DELETE', sprintf('%s/%s', self::PATH, $name));
	}

}
