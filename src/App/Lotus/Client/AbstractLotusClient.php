<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use Contributte\Utils\Validators;
use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Exception\LogicalException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractLotusClient extends AbstractHttpClient
{

	/** @var string|null  */
	protected $sudo;

	public function enableSudo(string $email): void
	{
		if (!Validators::isEmail($email)) {
			throw new LogicalException('You must provide valid email when enabling sudo');
		}

		$this->sudo = $email;
	}

	public function disableSudo(): void
	{
		$this->sudo = NULL;
	}

	public function isSudo(): bool
	{
		return $this->sudo !== NULL;
	}

	/**
	 * @param mixed[] $options
	 */
	public function request(string $method, string $uri, array $options = []): ResponseInterface
	{
		if ($this->isSudo()) {
			$options = array_merge_recursive($options, ['headers' => ['X-Sudo' => $this->sudo]]);
		}

		return $this->httpClient->request($method, $uri, $options);
	}

}
