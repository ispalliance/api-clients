<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Adminus\Requestor;

use ISPA\ApiClients\App\Adminus\Client\CustomerClient;
use ISPA\ApiClients\Domain\AbstractRequestor;
use Psr\Http\Message\ResponseInterface;

class CustomerRequestor extends AbstractRequestor
{

	/** @var CustomerClient */
	private $client;

	public function __construct(CustomerClient $client)
	{
		$this->client = $client;
	}

	public function getAll(): ResponseInterface
	{
		$resp = $this->client->getAll();

		$this->assertResponse($resp);

		return $resp;
	}

	/**
	 * @param string|int $id
	 */
	public function getById($id): ResponseInterface
	{
		$resp = $this->client->getById($id);

		$this->assertResponse($resp);

		return $resp;
	}

	/**
	 * @param string|int $cardNumber
	 */
	public function getByCard($cardNumber): ResponseInterface
	{
		return $this->client->getByCard($cardNumber);
	}

	public function getByFilter(string $query): ResponseInterface
	{

		$resp = $this->client->getByFilter($query);

		$this->assertResponse($resp, [200, 404]);

		return $resp;
	}

	/**
	 * @param string|int $interval Seconds count
	 */
	public function getByLastChange($interval): ResponseInterface
	{
		$resp = $this->client->getByLastChange($interval);

		$this->assertResponse($resp);

		return $resp;
	}

	/**
	 * @param string|int $from Unix timestamp
	 */
	public function getByLastChangeFrom($from): ResponseInterface
	{
		$resp = $this->client->getByLastChangeFrom($from);

		$this->assertResponse($resp);

		return $resp;
	}

	/**
	 * @param string|int $from
	 * @param string|int $to
	 */
	public function getByIdFromTo($from, $to): ResponseInterface
	{
		$resp = $this->client->getByIdFromTo($from, $to);

		$this->assertResponse($resp);

		return $resp;
	}

	/**
	 * NOTE: api for retrieving following list is not prepared yet
	 * When it's ready, replace array below with getting data from API
	 *
	 * @return mixed[]
	 */
	public function getAvailableSearchParams(): array
	{
		return [
			'karta' => [
				'description' => 'hledá dle čísla karty zákazníka, lze použít i zkrácený zápis `k`',
				'examples' => ['k:2412'],
			],
			'titul' => [
				'description' => '  hledá dle titulu zákazníka  
                                *(najde i hodnoty s částečnou shodou)*
            ',
				'examples' => ['titul:ing'],
			],
			'obcanka' => [
				'description' => 'hledá dle čísla občanského průkazu zákazníka',
				'examples' => ['obcanka:123456'],
			],
			'rc' => [
				'description' => 'hledá dle rodného čísla zákazníka',
				'examples' => ['rc:8311251234'],
			],
			'jmeno' => [
				'description' => '  hledá dle jména zákazníka, lze použít i zkrácený zápis `j`  
                                *(najde i hodnoty s částečnou shodou)*
            ',
				'examples' => ['j:pavel'],
			],
			'prijmeni' => [
				'description' => '  hledá dle příjmení zákazníka, lze použít i zkrácený zápis `p`  
                                *(najde i hodnoty s částečnou shodou)*
            ',
				'examples' => ['p:novak'],
			],
			'ic' => [
				'description' => 'hledá dle IČ zákazníka',
				'examples' => ['ic:123456'],
			],
			'dic' => [
				'description' => 'hledá dle DIČ zákazníka',
				'examples' => ['dic:CZ123456'],
			],
			'vs' => [
				'description' => 'hledá dle variabilního symbolu zákazníka',
				'examples' => ['vs:1250'],
			],
			'vlastnisipo' => [
				'description' => 'hledá dle toho zda má zákazník nastavenou jako platební metodu SIPO',
				'examples' => ['vlastnisipo:1'],
			],
			'vlastniinkaso' => [
				'description' => 'hledá dle toho zda má zákazník nastaven jako platební typ inkaso',
				'examples' => ['vlastniinkaso:1'],
			],
			'sipo' => [
				'description' => 'hledá dle SIPO čísla zákazníka',
				'examples' => ['sipo:147852369'],
			],
			'email' => [
				'description' => 'hledá dle emailu zákazníka',
				'examples' => ['email:adminus@tlapnet.cz'],
			],
			'telefon' => [
				'description' => 'hledá dle telefonního čísla zákazníka bez ohledu na typ, lze použít i zkrácený zápis `tel`',
				'examples' => ['tel:733123456'],
			],
			'ip' => [
				'description' => '  hledá dle zákaznické IP adresy  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['ip:192.168.1.2', 'ip:0', 'ip:1'],
			],
			'verejnaip' => [
				'description' => '  hledá dle veřejné IP adresy (hledá pouze mezi zákazníky kteří mají zadanou IP adresu)  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['verejnaip:12.12.12.12', 'verejnaip:0', 'verejnaip:1'],
			],
			'aktivni' => [
				'description' => 'umožňuje vyhledat neaktivní/smazané zákazníky',
				'examples' => ['aktivni:0'],
			],
			'sluzba' => [
				'description' => 'hledání podle názvu služby, najde všechny zákazníky, kteří mají uzavřenou alespoň jednu smlouvu na uvedenou službu',
				'examples' => ['sluzba:Tlapnet VoIp'],
			],
			'bezsluzby' => [
				'description' => 'hledání zákazníků, kteří nemají uzavřenou smlouvu na uvedenou službu',
				'examples' => ['bezsluzby:Tlapnet VoIp'],
			],
			'tarif' => [
				'description' => 'hledání podle aktivního tarifu',
				'examples' => ['tarif:Economic PLUS'],
			],
			'atribut' => [
				'description' => '  hledání podle atributů smluv zákazníka
                                podle zápisu lze určit, zda má hledat ve všech atributech nebo jen atributu konkrétního jména
                                - `atribut:www.seznam.cz` hledá hodnotu "www.seznam.cz" ve všech atributech
                                - `atribut:[doména:www.seznam.cz]` hledá hodnotu "www.seznam.cz" pouze v atributu s názvem "doména"
                                - `atribut:[poznámka:null]` najde zákazníky u kterých doposud nebyla zadána žádná hodnota do atributu "poznámka"
                            ',
				'examples' => ['atribut:www.seznam.cz', 'atribut:[doména:www.seznam.cz]', 'atribut:[SLA:1]', 'atribut:[poznámka:null]'],
			],
			'typuvazku' => [
				'description' => 'hledání podle typu úvazku, číslo značí počet let, 0 značí dobu neurčitou',
				'examples' => ['typuvazku:0'],
			],
			'smlstav' => [
				'description' => '  hledání podle stavu smlouvy (automatická nápověda)
                                - kombinuje se se "služba" tj. pokud se hledá jak podle klíče "služba" tak podle klíč "smlstav", tak jsou ve výsledku uvažovány jen ty smlouvy které jsou uzavřeny na danou službu a mají daný stav
                                - smlouvy ve stavu "Nový", lze hledat pomocí výrazu `smlstav:[Nový]`  
                                *(najde i hodnoty s částečnou shodou)*
                                ',
				'examples' => ['smlstav:Odpojen'],
			],
			'smlstavdele' => [
				'description' => 'hledá dle smlouvy se stavem trvajícím déle než zadaný počet dní (vhodné kombinovat se smlstav)',
				'examples' => ['smlstavdele:30'],
			],
			'smlstavtrvani' => [
				'description' => 'smlouvy se stavem trvajícím počet dní (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['smlstavtrvani>30'],
			],
			'smlaktivni' => [
				'description' => 'hledá dle zákazníků kteří mají smlouvy, jejichž stav je označen jako aktivní (1 aktivní, 0 neaktivní)',
				'examples' => ['smlaktivni:1'],
			],
			'rozsah' => [
				'description' => 'hledá zákazníky, kteří mají u některé ze smluv evidovanou IP adresu v daném IP rozsahu, lze použít i zkrácený zápis `ipr`',
				'examples' => ['ipr:192.168.143.101/27'],
			],
			'mac' => [
				'description' => '  hledá dle MAC adresy zákaznického zařízení evidovaného u některé ze zákaznických smluv, namísto dvojtečky použijte v hledané MAC adrese znak pomlčky  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['mac:01-23-45-67'],
			],
			'banka' => [
				'description' => 'hledá dle čísla účtu zákazníka',
				'examples' => ['banka:1234/0800'],
			],
			'pozn' => [
				'description' => '  hledá v poznámkách u zákazníka  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['pozn:text'],
			],
			'smlouva' => [
				'description' => 'hledá zákazniky dle čísel zákaznických smluv, lze použít i zkrácený zápis `cs`',
				'examples' => ['cs:1257'],
			],
			'predplaceno' => [
				'description' => 'hledá zákazníky, kteří mají k aktuálnímu datu předplacenou alespoň jednu ze svých smluv',
				'examples' => ['predplaceno:1'],
			],
			'pozastaveno' => [
				'description' => 'hledá zákazníky, kteří mají k aktuálnímu datu pozastavenou alespoň jednu ze svých smluv',
				'examples' => ['pozastaveno:1'],
			],
			'ssid' => [
				'description' => '  hledá dle SSID vysílače  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['ssid:ZlebyAP3'],
			],
			'adresa' => [
				'description' => '  Hledá dle zákaznické adresy, lze zadat komplexní adresu např. ve tvaru *Palackého 471 Čáslav*, nebo *Bousov 123* apod.  
                                Pokud není vyhledávání dle celkové adresy úspěšné, použijte vyhledávání s konkrétní specifikací jednotlivých částí adresy např. 
                                `ulice:palackého, mesto:caslav, cp: 471`, lze použít i zkrácený zápis `a`  
                                *(najde i hodnoty s částečnou shodou)*
            ',
				'examples' => ['adresa:Palackého 471 Čáslav', 'Bousov 123'],
			],
			'mesto' => [
				'description' => '  hledá město v zákaznických adresách, lze použít i zkrácený zápis `m`  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['m:pardubice'],
			],
			'ulice' => [
				'description' => '  hledá ulici v zákaznických adresách, lze použít i zkrácený zápis `u`  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['u:novakova'],
			],
			'bezsmsnotifikace' => [
				'description' => 'najde zákazníky bez SMS notifikace, tj. takové, kteří nemají buď zadané žádné telefonní číslo a nebo nemají povolenou notifikaci u žádného z evidovaných čísel',
				'examples' => ['bezsmsnotifikace:1'],
			],
			'bezemailnotifikace' => [
				'description' => 'najde zákazníky bez e-mailové notifikace, tj. takové, kteří nemají buď zadaný žádný e-mail a nebo nemají povolenou notifikaci u žádného z evidovaných e-mailů',
				'examples' => ['bezemailnotifikace:1'],
			],
			'typadresy' => [
				'description' => 'při vyhledávání adresy zákazníka (nebo některé z částí adresy jako město, ulice apod.) umožňuje omezit výsledky pouze na určitý typ adresy',
				'examples' => ['město:Praha, typadresy:fakturační'],
			],
			'psc' => [
				'description' => '  hledá dle PSČ v zákaznických adresách, lze uvést i více PSČ a ty oddělit symbolem "|"  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['psc:53854', 'psc:53854|53901|53944'],
			],
			'cp' => [
				'description' => 'hledá dle čísla popisného v zákaznických adresách',
				'examples' => ['cp:1234'],
			],
			'co' => [
				'description' => 'hledá dle čísla orientačního v zákaznických adresách',
				'examples' => ['co:1234'],
			],
			'posta' => [
				'description' => '  hledá dle pošty v zákaznických adresách  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['posta:přelouč'],
			],
			'apozn' => [
				'description' => '  hledá v poznámkách zákaznických adres  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['apozn:text'],
			],
			'tag' => [
				'description' => '  hledá zákazníky podle štítků  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['tag:Řeší se'],
			],
			'tagtrvani' => [
				'description' => '  hledá tagy s datem vytvoření podle počtu dní od aktuálního data (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['tagtrvani>30'],
			],
			'beztagu' => [
				'description' => '  hledá zákazníky, kteří nemají štítek  
                                *(najde i hodnoty s částečnou shodou)*',
				'examples' => ['beztagu:Řeší se'],
			],
			'smlsum' => [
				'description' => 'hledá zákazníky u kterých platí, že hodnota měsíční fakturace některé z jejich smluv odpovídá zadanému limitu (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;), platí i pro zákazníky s jinou než měsíční periodou vystavování faktur (hodnota se přepočítá na měsíční)',
				'examples' => ['smlsum<500'],
			],
			'smlpocet' => [
				'description' => 'hledá dle počtu smluv (v libobolném stavu) u zákazníka (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;), na dotaz smlpocet=0 vrací zákazníky bez jediné smlouvy',
				'examples' => ['smlpocet=1'],
			],
			'zaksum' => [
				'description' => 'hledá dle celkové měsíční fakturace zákazníka, odpovídá vyhledávání dle smlsum, jen bere v úvahu součet částek u všech smluv zákazníka (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['zaksum<500'],
			],
			'dluh' => [
				'description' => 'hledá zákazníky, kteří dluží k dnešnímu datu uvedenou částku (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['dluh<500'],
			],
			'preplatek' => [
				'description' => 'hledá zákazníky, kteří mají k dnešnímu datu přeplatek (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['preplatek>1000'],
			],
			'bezp' => [
				'description' => 'hledá zákazníky, kteří nemají u žádné ze svých smluv k aktuálnímu dni žádné aktivní fakturační pravidlo',
				'examples' => ['bezp:1'],
			],
			'pridal' => [
				'description' => 'hledá zákazníky podle jména či příjmení uživatele systému Adminus, který ho do systému přidal',
				'examples' => ['pridal:novák'],
			],
			'zakvznikl' => [
				'description' => 'hledá zákazníky podle data/roku vzniku smlouvy (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['zakvznikl>1.4.2017', 'zakvznikl>2017'],
			],
			'narozeni' => [
				'description' => 'hledá zákazníky podle data narození (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['narozeni>1.4.1980', 'narozeni>1980', 'narozeni<=1990'],
			],
			'narozeniny' => [
				'description' => 'hledá zákazníky kteří mají narozeniny v daných dnech, parametr je počet dní od aktuálního dne
                            - `narozeniny:1` uživatelé kteří mají narozeniny zítra
                            - `narozeniny:0` uživatelé kteří mají narozeniny dnes
                            - `narozeniny:-1` uživatelé kteří měli narozeniny včera
                            ',
				'examples' => ['narozeniny:1', 'narozeniny:0', 'narozeniny:-1'],
			],
			'svatek' => [
				'description' => 'hledá zákazníky kteří mají svátek v daných dnech, parametr je počet dní od aktuálního dne
                            - `svatek:1` uživatelé kteří mají svátek zítra
                            - `svatek:0` uživatelé kteří mají svátek dnes
                            - `svatek:-1` uživatelé kteří měli svátek včera
                            ',
				'examples' => ['svatek:1', 'svatek:0', 'svatek:-1'],
			],
			'konecuvazku' => [
				'description' => 'hledá zákazníky dle toho, kdy některé z jejich smluv končí úvazek za daný počet dní (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['konecuvazku>30'],
			],
			'konecpredplaceni' => [
				'description' => ' hledá zákazníky dle toho, kdy některé z jejich smluv končí předplacení za daný počet dní (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)  
                                pokud se zada zaporna hodnota, tak lze hledat i predplaceni, ktera jiz skoncila:
                                - `konecpredplaceni<-30` najde predplaceni, ktera jiz skoncila a skoncila pred mene jak 30-ti dny 
                                - `konecpredplaceni>-30` najde predplaceni, ktera jiz skoncila a skoncila pred vice jak 30-ti dny 
                                
            ',
				'examples' => ['konecpredplaceni<=7', 'konecpredplaceni>-30', 'konecpredplaceni=14'],
			],
			'bezupominky' => [
				'description' => 'hledá zákazníky, kteří jsou počet dní bez aktivní (neakceptované) upomínky (lze použít operátory &lt;,&lt;=,=,&gt;=,&gt;)',
				'examples' => ['bezupominky>30'],
			],
			'zarizeni' => [
				'description' => 'hledá zákazníky, kteří mají ve vlastnictví zařízení s aktivním fakturačním pravidlem',
				'examples' => ['zarizeni:Tenda N30'],
			],
			'zakatribut' => [
				'description' => '  hledání podle zákaznických atributů, podle zápisu lze určit, zda má hledat ve všech atributech nebo jen v atributu konkrétního jména
                                - `zakatribut:www.seznam.cz` hledá hodnotu "www.seznam.cz" ve všech zákaznických atributech
                                - `zakatribut:[doména:www.seznam.cz]` hledá hodnotu "www.seznam.cz" pouze v zákaznickém atributu s názvem "doména"
                                - `zakatribut:[poznámka:null]` najde zákazníky u kterých doposud nebyla zadána žádná hodnota do zákaznického atributu "poznámka"
                            ',
				'examples' => ['zakatribut:www.seznam.cz', 'zakatribut:[doména:www.seznam.cz]', 'zakatribut:[SLA:1]', 'zakatribut:[poznámka:null]'],
			],
		];
	}

}
