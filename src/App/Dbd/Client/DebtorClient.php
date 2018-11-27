<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Dbd\Client;

use InvalidArgumentException;
use ISPA\ApiClients\App\Dbd\Entity\Company;
use ISPA\ApiClients\App\Dbd\Entity\Person;
use ISPA\ApiClients\App\Dbd\Entity\TestPerson;
use ISPA\ApiClients\App\Dbd\Http\AbstractDbdSoapClient;
use ISPA\ApiClients\Exception\RuntimeException;
use ISPA\ApiClients\Utils\Xml\Helpers;
use SimpleXMLElement;

class DebtorClient extends AbstractDbdSoapClient
{

	/**
	 * @param Person|Company $subject
	 */
	public function check(object $subject): SimpleXMLElement
	{
		if ($this->isTestMode()) {
			$subject = TestPerson::get();
		}

		$params = $this->prepareParams($subject);
		$response = $this->soapClient->call('Minister_Check', $params);

		$xml = Helpers::strToXml($response);

		$this->validateResponse($xml);

		return $xml;
	}

	/**
	 * @param Person|Company $subject
	 * @return mixed[]
	 */
	private function prepareParams(object $subject): array
	{
		$params = [$this->config['http']['auth']['user'], $this->config['http']['auth']['pass']];

		switch (TRUE) {

			case $subject instanceof Person:
				/** @var Person $Subject */
				return array_merge(
					$params,
					[
						$subject->getPin(),
						$subject->getBirthDate(),
						$subject->getFirstName(),
						$subject->getLastName(),
					]
				);

			case $subject instanceof Company:
				/** @var Company $subject */
				return array_merge($params, [$subject->getId(), '', '', '']);

			default:
				throw new InvalidArgumentException('Only Person and Company objects are allowed to be checked.');
		}
	}

	private function validateResponse(SimpleXMLElement $xml): void
	{
		if ($xml->errorcode) {
			throw new RuntimeException(sprintf('Remote API returned error code: %s. Message: %s', $xml->errorcode, $xml->errordescr));
		}
	}

	private function isTestMode(): bool
	{
		if (array_key_exists('config', $this->config) && array_key_exists('test', $this->config['config'])) {
			return $this->config['config']['test'] === TRUE;
		}

		return FALSE;
	}

}
