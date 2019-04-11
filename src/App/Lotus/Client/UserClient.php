<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractLotusClient
{

	private const PATH = 'users';

	public function list(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
		]);
		return $this->request('GET', sprintf('%s?%s', self::PATH, $query));
	}

	public function getById(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/detail/%d', self::PATH, $id));
	}

	public function getByEmail(string $email): ResponseInterface
	{
		$query = Helpers::buildQuery(['email' => $email]);
		return $this->request('GET', sprintf('%s/detail/email?%s', self::PATH, $query));
	}

	/**
	 * @param int[] $userIds
	 */
	public function combineUserGroup(string $gid, array $userIds, bool $includeSystemUsers = FALSE, bool $includeBlockedUsers = FALSE): ResponseInterface
	{
		$query = [
			'system' => $includeSystemUsers ? 'true' : 'false',
			'blocked' => $includeBlockedUsers ? 'true' : 'false',
		];
		$query = Helpers::buildQuery($query);

		return $this->request(
			'PATCH',
			sprintf('%s/%s/combine?%s', self::PATH, $gid, $query),
			[
				'body' => Json::encode([
					'ids' => $userIds,
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function getMentions(string $query): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/mentions/%s', self::PATH, $query));
	}

}
