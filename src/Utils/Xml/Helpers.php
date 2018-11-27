<?php declare(strict_types = 1);

namespace ISPA\ApiClients\Utils\Xml;

use ISPA\ApiClients\Exception\RuntimeException;
use LibXMLError;
use SimpleXMLElement;

final class Helpers
{

	public static function strToXml(string $data): SimpleXMLElement
	{
		$xml = simplexml_load_string($data);

		if ($xml === FALSE) {
			/** @var LibXMLError $error */
			foreach (libxml_get_errors() as $error) {
				throw new RuntimeException(sprintf('Error parsing XML string: %s', $error->message));
			}

			throw new RuntimeException(sprintf('Error parsing XML response.'));
		}

		return $xml;
	}

}
