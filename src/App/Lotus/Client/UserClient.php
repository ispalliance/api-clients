<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\App\Lotus\Entity\UserCreateEntity;
use ISPA\ApiClients\App\Lotus\Entity\UserEditEntity;
use ISPA\ApiClients\App\Lotus\Filter\UserListFilter;
use ISPA\ApiClients\Http\Utils\Helpers;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractLotusClient
{

	private const PATH = 'users';

	public function list(int $limit = 10, int $offset = 0, ?UserListFilter $filter = NULL): ResponseInterface
	{
		$parameters = [
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
		];

		if ($filter !== NULL) {
			$state = $filter->getState();
			if ($state !== NULL) {
				$parameters['state'] = $state;
			}

			$email = $filter->getEmail();
			if ($email !== NULL) {
				$parameters['email'] = $email;
			}

			$id = $filter->getId();
			if ($id !== NULL) {
				$parameters['id'] = $id;
			}

			$username = $filter->getUsername();
			if ($username !== NULL) {
				$parameters['username'] = $username;
			}
		}

		return $this->request('GET', sprintf('%s?%s', self::PATH, Helpers::buildQuery($parameters)));
	}

	public function getById(int $id): ResponseInterface
	{
		return $this->request('GET', sprintf('%s/%d', self::PATH, $id));
	}

	public function create(UserCreateEntity $entity): ResponseInterface
	{
		return $this->request(
			'POST',
			sprintf('%s', self::PATH),
			[
				'body' => Json::encode([
					'name' => $entity->getName(),
					'surname' => $entity->getSurname(),
					'email' => $entity->getEmailAddress(),
					'password' => $entity->getPassword(),
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

	public function edit(UserEditEntity $entity): ResponseInterface
	{
		return $this->request(
			'PUT',
			sprintf('%s/%s', self::PATH, $entity->getId()),
			[
				'body' => Json::encode([
					'name' => $entity->getName(),
					'surname' => $entity->getSurname(),
					'username' => $entity->getUserName(),
					'email' => $entity->getEmailAddress(),
				]),
				'headers' => [
					'Content-Type' => 'application/json',
				],
			]
		);
	}

}
