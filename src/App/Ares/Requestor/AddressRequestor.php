<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Requestor;

use ISPA\ApiClients\App\Ares\Client\AddressClient;
use ISPA\ApiClients\App\Ares\Entity\Address;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Psr\Http\Message\ResponseInterface;
use SimpleXMLElement;

class AddressRequestor extends BaseRequestor
{

	/** @var AddressClient */
	private $client;

	public function __construct(AddressClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @throws InvalidIdNumberException
	 * @throws SubjectNotFoundException
	 */
	public function get(string $idNumber): Address
	{
		$response   = $this->client->get($idNumber);
		$odpovedElm = $this->getResponseElement($response);

		if ((int) $odpovedElm->Pocet_zaznamu === 0) {
			throw SubjectNotFoundException::create($idNumber);
		}

		$adresaElms = null;

		if (isset($odpovedElm->Zaznam[0]->Identifikace[0]->Adresa_ARES[0])) {
			$adresaElm = $odpovedElm->Zaznam[0]->Identifikace[0]->Adresa_ARES[0];
			$ns        = $adresaElm->getNamespaces(true);

			if (isset($ns['dtt'])) {
				$adresaElms = $adresaElm->children($ns['dtt']);
			}
		}

		return new Address(
			(string) ($odpovedElm->Zaznam[0]->Obchodni_firma ?? ''),
			(string) ($adresaElms->Nazev_ulice ?? ''),
			(string) ($adresaElms->Cislo_domovni ?? ''),
			(string) ($adresaElms->Cislo_orientacni ?? ''),
			(string) ($adresaElms->Nazev_obce ?? ''),
			(string) ($adresaElms->Nazev_casti_obce ?? ''),
			(string) ($adresaElms->PSC ?? '')
		);
	}

	protected function getResponseElement(ResponseInterface $response): SimpleXMLElement
	{
		$elm = parent::getResponseElement($response);

		if (isset($elm->Error[0])) {
			$this->processError($elm->Error[0], $response);
		}

		return $elm;
	}

	private function processError(SimpleXMLElement $errorElm, ResponseInterface $response): void
	{
		$ns = $errorElm->getNamespaces(true);

		if (!isset($ns)) {
			throw new ResponseException($response, 'Missing namespace "dtt" in "are:Ares_odpovedi[0]->are:Odpoved[0]->are:Error[0]".');
		}

		$errorElms = $errorElm->children($ns['dtt']);

		if (isset($errorElms->Error_text[0])) {
			throw new ResponseException($response, (string) $errorElms->Error_text[0]);
		}

		throw new ResponseException($response, 'Missing node "are:Ares_odpovedi[0]->are:Odpoved[0]->are:Error[0]->dtt:Error_text[0]".');
	}

}
