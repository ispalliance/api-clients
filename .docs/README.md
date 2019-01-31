# ISPA API

This is aggregated central API client with delightful usage.


## Configuration

At first, register main extension in your NEON.

```yaml
extensions:
    ispa.api: ISPA\ApiClients\DI\ApiClientsExtension

ispa.api:
    debug: %debugMode%
```

Secondly, configure single application. We support these applications:
 - **adminus**
 - **ares**
 - **dbd**
 - **lotus**
 - **nominatim**
 - **pedef**
 - **ruian**

```yaml
ispa.api:
    app:
        <name>:
            http:
                base_uri: http://example.com/api/v1/
```

Each application has `http` key for configuring its HTTP client. By default this is the Guzzle client, 
take a look at [Guzzle doc](https://guzzle.readthedocs.io/en/latest/quickstart.html).

You could also disable client entirely.

```yaml
ispa.api:
    app:
        <name>: false
```

## Architecture

```
ApiProvider -> *Rootquestor(s) -> *Requestor(s) -> endpoint method 
```

There are many ways how to use this aggregated API clients.

### ApiProvider

This is high-level managed API layer.

```php
/** @var ApiProvider @inject */
public $api;

public function magic(): void
{
    $users = $this->api->lotus->users->getAll()
}
```

You can access all defined application's API services and then their requestors.

```php
$this->api->{app}->{requestor}->{method}
```

### Rootquestor

This is middle-level way how to manage our APIs.

```php
/** @var LotusRootquestor @inject */
public $api;

public function magic(): void
{
    $users = $this->api->users->getAll();
}
```

You can directly pick one of the **rootquestor** and access his **requestors**. This is limited by single API.

### Guzzle

This is very low-level of managing our APIs. It's basically only configured
Guzzle client with credentials, timeout settings etc for particular application.

Official documentation for [Guzzle is here](https://guzzle.readthedocs.io/en/latest/quickstart.html).

```php
/** @var GuzzleAppFactory @inject */
public $guzzleFactory;

public function magic(): void
{
    $client = $this->guzzleFactory->create('lotus');
    $users = $client->get("users");
}
```

# 3rd

## Adminus

### Configuration

```yaml
ispa.api:
    app:
        adminus:
            http:
                base_uri: http://adminus.example.com/api/
```

### Available requestor's methods

**AccountingEntityRequestor**

| Method           | API path                         | Type |
| ---------------- | -------------------------------- |----- |
| getAll()         | .../accounting-entity/{$id}      | GET  |
| getById($id)     | .../accounting-entity/{$id}      | GET  |
| getAllBanks()    | .../accounting-entity-blank      | GET  |
| getBankById($id) | .../accounting-entity-blank/{$id}| GET  |


**ContractRequestor**

| Method                                              | API path                                                                      | Type |
| --------------------------------------------------- | ----------------------------------------------------------------------------- | ---- |
| getById($id)                                        | .../contract-detail/by-id/{$id}                                               | GET  |
| getByContractNumber($contractNumber)                | .../contract-detail/by-contract-number/{$contractNumber}                      | GET  |
| getByCustomer($customerId)                          | .../contract-detail/by-customer/{$customerId}                                 | GET  |
| getByCustomerCard($cardNumber)                      | .../contract-detail/by-customer-card/{$cardNumber}                            | GET  |
| getByAttributeSetId($attributeSetId)                | .../contract-detail/by-attribute-set-id/{$attributeSetId}                     | GET  |
| getOnlyActive()                                     | .../contract-detail/only-active                                               | GET  |
| setStateById($contractId, $stateId)                 | .../contract-detail/set-state/{$contractId}/{$stateId}                        | PUT  |
| setStateByContractNumber($contractNumber, $stateId) | .../contract-detail/set-state-by-contract-number/{$contractNumber}/{$stateId} | PUT  |
| getAllContractTypeStates()                          | .../contract-type-state                                                       | GET  |
| getContractTypeStateById($id)                       | .../contract-type-state/{$id}                                                 | GET  |

**CustomerRequestor**

| Method                     | API path                                        | Type |
| -------------------------- | ----------------------------------------------- | ---- |
| getAll()                   | .../customer-detail/all                         | GET  |
| getById($id)               | .../customer-detail/by-id/{$id}                 | GET  |
| getByCard($cardNumber)     | .../customer-detail/by-card/{$cardNumber}       | GET  |
| getByFilter(string $query) | .../customer-detail/by-filter/{$query}          | GET  |
| getByLastChange($interval) | .../customer-detail/by-last-change/{$interval}  | GET  |
| getByLastChangeFrom($from) | .../customer-detail/by-last-change-from/{$from} | GET  |
| getByIdFromTo($from, $to)  | .../customer-detail/by-id-from-to/{$from}/{$to} | GET  |

**UserRequestor**

| Method        | API path       | Type |
| ------------- | -------------- | ---- |
| getAll()      | .../user       | GET  |
| getById($id)  | .../user/{$id} | GET  |


## ARES

### Configuration

```yaml
ispa.api:
    app:
        ares:
            http:
                base_uri: http://example.com/api/
```

### Available requestor's methods

**AddressRequestor**

| Method                         | API path                                          | Type |
| -------------------------------| ------------------------------------------------- |----- |
| get(string $idNumber): Address | https://wwwinfo.mfcr.cz/cgi-bin/ares/darv_std.cgi | GET  |

**SubjectRequestor**

| Method                         | API path                                         | Type |
| -------------------------------| ------------------------------------------------ |----- |
| get(string $idNumber): Subject | https://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi | GET  |
| getAll(string $name): array    | https://wwwinfo.mfcr.cz/cgi-bin/ares/ares_es.cgi | GET  |

### Examples 

#### Get subject

```php
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;

try {
    $subject = $api->ares->subject->get('IDENTIFICATION_NUMBER');
} catch (InvalidIdNumberException $e) {
    // Do something
} catch (SubjectNotFoundException $e) {
    // Do something
}
```


#### Get subjects

```php
use ISPA\ApiClients\App\Ares\Exception\Runtime\TooManySubjectsException;

try {
    $subjects = $api->ares->subject->getAll('NAME');
} catch (TooManySubjectsException $e) {
    // Do something
}
```


#### Get address


```php
use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;

try {
    $subject = $api->ares->address->get('IDENTIFICATION_NUMBER');
} catch (InvalidIdNumberException $e) {
    // Do something
} catch (SubjectNotFoundException $e) {
    // Do something
}
```

## DBD

Please note that DBD client communicates using SOAP, thus configuration key 'soap' is used. 
`wsdl`, `user` and `pass` subkeys are requried.

All requests to remote API are being charged, so it is recommended to have `test` option enabled during testing and debugging.

### Configuration

```yaml
ispa.api:
    app:
        dbd:
            http:
                wsdl: 'http://ws.dcgroup.cz/index.php?WSDL'
                auth: 
                    user: foo
                    pass: bar
            config: 
                test: TRUE
```

### Available requestor's methods

**DebtorRequestor**

| Method                                 | SOAP method    | Type  |
| -------------------------------------- | ---------------|------ |
| checkPerson(Person $person): Result    | Minister_Check | SOAP  |
| checkCompany(Company $company): Result | Minister_Check | SOAP  |


## Lotus

### Configuration

```yaml
lotus.api:
    app:
        lotus:
            http:
                base_uri: http://lotus.ispa.cz/api/v1/
                headers: 
                    X-Api-Token: validGeneratedAppToken
```

### Available requestor's methods

**UserRequestor**

| Method                    | API path                    | Type |
| --------------------------| --------------------------- |----- |
| list($limit, $offset)     | .../users                   | GET  |
| getById(int $id)          | .../users/detail/{$id}      | GET  |
| getByEmail(string $email) | .../users/detail/email{$id} | GET  |

**ProcessRequestor**

| Method                                                                           | API path                                              | Type |
| ---------------------------------------------------------------------------------| ----------------------------------------------------- |----- |
| listProcesses($limit, $offset)                                                   | .../processes                                         | GET  |
| listProcessesByVariables(array $variables)                                       | .../processes/find-by-variables                       | POST |
| getProcess(int $id)                                                              | .../processes/detail/{$id}                            | GET  |
| listTemplates($limit, $offset)                                                   | .../template-processes                                | GET  |
| listStartableTemplates()                                                         | .../template-processes/startable                      | GET  |
| getTemplate(int $id)                                                             | .../template-processes/detail/{$id}                   | GET  |
| startProcess(int $id, array $data)                                               | .../start-process                                     | POST |
| uploadFile(int $processId, string $variable, string $fileName, string $contents) | .../process/{$processId}/upload?variable=%{$variable} | POST |

Note: listProcessesByVariables expects $variables to be array of variables to search for in format ["name" => "value", ...] eg ["user" => "10", "status" => "active"]

## Nominatim

### Configuration

```yaml
ispa.api:
    app:
        nominatim:
            http:
                base_uri: https://nominatim.openstreetmap.org
```

### Available requestor's methods

**AddressRequestor**

Allows you to get gps coordinates for given address or in reverse get address from given coordinates. 

| Method                               | API path                    | Type |
| -------------------------------------| --------------------------- |----- |
| findByCoords(float $lat, float $lng) | .../reverse                 | GET  |
| findByAddress(Address $address)      | .../                        | GET  |


## Pedef

### Configuration

```yaml
ispa.api:
    app:
        pedef:
            http:
                base_uri: http://pedef.example.com/api/
```
### Available requestor's methods

**ThumbnailRequestor**

| Method                                                                      | API path | Type |
| ----------------------------------------------------------------------------| ---------|----- |
| generateThumbnail(string $contents, string $name, string $fileName): string | base_uri | POST |


## Ruian

### Configuration

```yaml
ispa.api:
    app:
        ruian:
            http:
                base_uri: http://ruian.example.com/api/
```

### Available requestor's methods

**AddressPlacesRequestor**

| Method                | API path                    | Type |
| ----------------------| ----------------------------|----- |
| getByCode             | .../by-code                 | GET  |
| getByCodes            | .../by-codes                | GET  |
| getByMunicipality     | .../by-municipality         | GET  |
| getByMunicipalityPart | .../by-part-of-municipality | GET  |
| getByStreet           | .../by-street               | GET  |
| getByRegion           | .../by-region               | GET  |
| getByDistrict         | .../by-district             | GET  |

**AutocompleteRequestor**

| Method                                     | API path                                              | Type |
| -------------------------------------------| ------------------------------------------------------|----- |
| getDistrictsByFilter                       | .../districts-by-filter                               | GET  |
| getMunicipalitiesWithPartsByFilter         | .../municipalities-with-parts-by-filter               | GET  |
| getStreetsByCityCodeAndFilter              | .../streets-by-filter                                 | GET  |
| getStreetsByCityPartCodeAndFilter          | .../streets-by-part-of-city-filter                    | GET  |
| getHouseNumbersByStreetCode                | .../house-numbers-by-street-code                      | GET  |
| getHouseNumbersWithoutStreetByCityCode     | .../house-numbers-without-street-by-city-code         | GET  |
| getHouseNumbersWithoutStreetByCityPartCode | .../house-numbers-without-street-by-part-of-city-code | GET  |

**BuildingObjectRequestor**

| Method | API path                             | Type |
| -------| -------------------------------------|----- |
| get    | .../address-register-building-object | GET  |

**CadastralAreaRequestor**

| Method             | API path                                | Type |
| -------------------| ----------------------------------------|----- |
| get($from, $limit) | .../address-register-cadastral-area     | GET  |
| getAll             | .../address-register-cadastral-area/all | GET  |

**DistrictRequestor**

| Method             | API path                          | Type |
| -------------------| ----------------------------------|----- |
| get($from, $limit) | .../address-register-district     | GET  |
| getAll             | .../address-register-district/all | GET  |

**MetaRequestor**

| Method                              | API path            | Type |
| ------------------------------------| --------------------|----- |
| getMeta                             | .../meta            | GET  |
| getModelInfo(string $restModelName) | .../meta/model-info | GET  |

**MunicipalityRequestor**

| Method             | API path                              | Type |
| -------------------| --------------------------------------|----- |
| get($from, $limit) | .../address-register-municipality     | GET  |
| getAll()           | .../address-register-municipality/all | GET  |

**MunicipalityPartRequestor**

| Method             | API path                                      | Type |
| -------------------| ----------------------------------------------|----- |
| get($from, $limit) | .../address-register-part-of-municipality     | GET  |
| getAll()           | .../address-register-part-of-municipality/all | GET  |

**ParcelRequestor**

| Method                                                               | API path                                                           | Type |
| ---------------------------------------------------------------------| -------------------------------------------------------------------|------|
| getByCode($code)                                                     | .../address-register-parcel/{$code}                                | GET  |
| getByCadastralArea($cadastralAreaCode)                               | .../address-register-parcel/by-cadastral-area/{$cadastralAreaCode} | GET  |
| getByCadastralAreaAndParcelNumber($cadastralAreaCode, $parcelNumber) | .../address-register-parcel/by-cadastral-area-and-parcel-number    | GET  |
| getByPolygon()                                                       | .../???  TODO                                                      | GET  |
| getByCircle($latitude, $longtitude, $radius)                         | .../???  TODO                                                      | GET  |

**RegionRequestor**

| Method             | API path                        | Type |
| -------------------| --------------------------------|----- |
| get($from, $limit) | .../address-register-region     | GET  |
| getAll()           | .../address-register-region/all | GET  |

**SearchRequestor**

| Method                | API path                                         | Type |
| ----------------------| -------------------------------------------------|----- |
| getByFilter           | .../address-register-search/by-filter            | POST |
| getMultipleByFilter   | .../address-register-search/multiple-by-filter   | POST |
| getByFulltext         | .../address-register-search/by-fulltext          | GET  |
| getMultipleByFulltext | .../address-register-search/multiple-by-fulltext | POST |
| getByPolygon          | .../address-register-search/by-polygon           | POST |
| getByCircle           | .../address-register-search/???   TODO           | GET  |

**StreetRequestor**

| Method             | API path                    | Type |
| -------------------| ----------------------------|----- |
| get($from, $limit) | .../address-register-street | GET  |

**ZsjRequestor**

| Method             | API path                 | Type |
| -------------------| -------------------------|----- |
| get($from, $limit) | .../address-register-zsj | GET  |
