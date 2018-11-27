<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\CPost\Client;

use DateTime;
use InvalidArgumentException;
use ISPA\ApiClients\App\CPost\Http\AbstractCpostHttpClient;
use ISPA\ApiClients\App\CPost\XmlRequest\Consignment\Consignment;
use ISPA\ApiClients\App\CPost\XmlRequest\ConsignmentRequestFactory;
use ISPA\ApiClients\Exception\LogicalException;
use ISPA\ApiClients\Http\HttpClient;
use Psr\Http\Message\ResponseInterface;

class ConsignmentClient extends AbstractCpostHttpClient
{

	private const PATH_CONSIGNMENT_SEND = 'donApi.php';
	private const PATH_CONSIGNMENT_DETAIL = 'donPrehledZak.php';

	/** @var ConsignmentRequestFactory */
	private $requestFactory;

	/**
	 * @param mixed[] $config
	 */
	public function __construct(HttpClient $httpClient, array $config)
	{
		parent::__construct($httpClient, $config);

		$this->requestFactory = new ConsignmentRequestFactory();
	}

	public function sendConsignment(Consignment $consignment): ResponseInterface
	{
		$tmpFile = $this->getTmpDir() . uniqid() . '.xml';
		$xml = $this->requestFactory->create($consignment);
		$this->createTmpFile($tmpFile, $xml);

		$options = array_merge(
			$this->getCommonRequestOptions(),
			[
				'multipart' => [
					[
						'name' => 'user',
						'contents' => $this->getUsername(),
					],
					[
						'name' => 'password',
						'contents' => $this->getPassword(),
					],
					[
						'name' => 'soubor',
						'contents' => fopen($tmpFile, 'r'),
					],
				],
				'defaults' => [
					'headers' => [
						'Content-Type' => 'multipart/form-data',
					],
				],
			]
		);

		$response = $this->httpClient->request('POST', self::PATH_CONSIGNMENT_SEND, $options);
		unlink($tmpFile);

		return $response;
	}

	public function getConsignment(?string $consignmentId = NULL, ?DateTime $date = NULL): ResponseInterface
	{
		if ($consignmentId === NULL && $date === NULL) {
			throw new InvalidArgumentException('You must provide consignmentId and/or date params');
		}

		$dateString = '';
		if ($date !== NULL) {
			$dateString = $date->format('Ymd');
		}

		$options = array_merge(
			$this->getCommonRequestOptions(),
			[
				'form_params' => [
					'user' => $this->getUsername(),
					'password' => $this->getPassword(),
					'zasilka' => $consignmentId ?? '',
					'datum' => $consignmentId !== NULL ? '' : $dateString,
				],
				'defaults' => [
					'headers' => [
						'Content-Type' => 'application/x-www-form-urlencoded',
					],
				],
			]
		);

		return $this->httpClient->request('POST', self::PATH_CONSIGNMENT_DETAIL, $options);
	}

	private function createTmpFile(string $path, string $content): void
	{
		$fh = fopen($path, 'w');

		if ($fh === FALSE) {
			throw new LogicalException(sprintf('Cannot create temp file %s', $path));
		}

		fwrite($fh, $content);
		fclose($fh);
	}

	/**
	 * @return mixed[]
	 */
	private function getCommonRequestOptions(): array
	{
		return [
			'timeout' => self::REQUEST_TIMEOUT,
			'verify' => array_key_exists('ssl_key', $this->config),
		];
	}

}
