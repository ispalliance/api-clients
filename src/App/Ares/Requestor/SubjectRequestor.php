<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Ares\Requestor;

use ISPA\ApiClients\App\Ares\Client\SubjectClient;
use ISPA\ApiClients\App\Ares\Entity\Subject;
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\TooManySubjectsException;
use ISPA\ApiClients\Exception\Runtime\ResponseException;
use Psr\Http\Message\ResponseInterface;

class SubjectRequestor extends BaseRequestor
{

	/** @var SubjectClient */
	private $client;

	public function __construct(SubjectClient $client)
	{
		$this->client = $client;
	}

	/**
	 * @throws InvalidIdNumberException
	 * @throws SubjectNotFoundException
	 */
	public function get(string $idNumber): Subject
	{
		$response = $this->client->get($idNumber);

		try {
			$subjects = $this->getSubjects($response, $idNumber);
		} catch (TooManySubjectsException $e) {
			// Should not occur
			throw SubjectNotFoundException::create($idNumber, $e);
		}

		$count = count($subjects);

		if ($count === 0) {
			throw SubjectNotFoundException::create($idNumber);
		}

		if ($count > 1) {
			// Should not occur
			throw SubjectNotFoundException::create($idNumber);
		}

		return $subjects[0];
	}

	/**
	 * @return Subject[]
	 * @throws TooManySubjectsException
	 */
	public function getAll(string $name): array
	{
		$response = $this->client->getAll($name);

		return $this->getSubjects($response, $name);
	}

	/**
	 * @return Subject[]
	 */
	private function getSubjects(ResponseInterface $response, string $name): array
	{
		$odpovedElm = $this->getResponseElement($response);
		$ns = $odpovedElm->getNamespaces(TRUE);

		if (!isset($ns['dtt'])) {
			throw new ResponseException($response, 'Missing namespace "dtt" in "are:Ares_odpovedi[0]->are:Odpoved[0]".');
		}

		$odpovedElms = $odpovedElm->children($ns['dtt']);

		if (isset($odpovedElms->Help[0]->R[0])) {
			$helpText = preg_replace('/(\s{2,})/u', ' ', trim((string) $odpovedElms->Help[0]->R[0]));

			if ($helpText === 'Zadané parametry vedou k výběru více subjektů než je zadáno v "Zobrazit vět". Upravte hlediska pro vyhledání.') {
				throw TooManySubjectsException::create($name);
			}
		}

		if (!isset($odpovedElms->Pocet_zaznamu)) {
			throw new ResponseException($response, 'Missing node "are:Ares_odpovedi[0]->are:Odpoved[0]->dtt:Pocet_zaznamu".');
		}

		$count = (int) $odpovedElms->Pocet_zaznamu;

		if ($count === 0) {
			return [];
		}

		$subjects = [];

		if (!isset($odpovedElms->V[0])) {
			throw new ResponseException($response, 'Missing node "are:Ares_odpovedi[0]->are:Odpoved[0]->dtt:V[0]".');
		}

		foreach ($odpovedElms->V->S as $sElm) {
			$vatIdNumber = NULL;

			if (isset($sElm->p_dph) && preg_match('/^dic=(\d+)$/', (string) $sElm->p_dph, $matches)) {
				$vatIdNumber = $matches[1];
			}

			$subjects[] = new Subject((string) $sElm->ojm, (string) $sElm->ico, $vatIdNumber, (string) $sElm->jmn);
		}

		return $subjects;
	}

}
