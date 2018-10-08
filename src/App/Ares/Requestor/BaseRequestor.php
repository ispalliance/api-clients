<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Requestor;

use ISPA\ApiClients\Domain\AbstractRequestor;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class BaseRequestor extends AbstractRequestor
{

	protected function getResponseElement(ResponseInterface $response): SimpleXMLElement
	{
		$this->assertResponse($response);

		$data = $response->getBody()->getContents();
		$elm = new SimpleXMLElement($data);
		$ns = $elm->getNamespaces(TRUE);

		if (!isset($ns['are'])) {
			throw new ResponseException($response, 'Missing namespace "are".');
		}

		$childElms = $elm->children($ns['are']);

		if (!isset($childElms->Odpoved[0])) {
			throw new ResponseException($response, 'Missing node "are:Ares_odpovedi[0]->are:Odpoved[0]".');
		}

		return $childElms->Odpoved[0];
	}

}
