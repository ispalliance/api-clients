<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Http;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

abstract class AbstractClient
{

	/** @var Client */
	protected $guzzle;

	public function __construct(Client $guzzle)
	{
		$this->guzzle = $guzzle;
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function get($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('GET', $uri, $opts);
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function head($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('HEAD', $uri, $opts);
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function post($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('POST', $uri, $opts);
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function put($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('PUT', $uri, $opts);
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function patch($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('PATCH', $uri, $opts);
	}

	/**
	 * @param string|UriInterface $uri
	 * @param mixed[] $opts
	 */
	public function delete($uri, array $opts = []): ResponseInterface
	{
		return $this->guzzle->request('DELETE', $uri, $opts);
	}

}
