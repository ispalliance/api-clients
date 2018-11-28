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

Secondly, configure single application. We support these applications **adminus**, **ares**, **lotus**, **pedef** and **ruian**.

```yaml
ispa.api:
    app:
        <name>:
            http:
                base_uri: http://example.com/api/v1/
```

Each application has `http` key for configure its http client. By default there is Guzzle client,
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

You can directly pick one of the **rootquestor** and access his **requestors**. This limit by single API.

### Guzzle

This is very low-level of managing our APIs. It's basically only configured
Guzzle client with credentials to single application.

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

### Endpoints

@todo


## ARES

### Configuration

```yaml
ispa.api:
    app:
        ares:
            http:
                base_uri: http://example.com/api/
```

### Endpoints 

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


### Lotus

### Configuration

```yaml
ispa.api:
    app:
        lotus:
            http:
                base_uri: http://adminus.example.com/api/
```

### Endpoints

@todo


### Pedef

### Configuration

```yaml
ispa.api:
    app:
        pedef:
            http:
                base_uri: http://adminus.example.com/api/
```

### Endpoints

@todo

### Ruian

### Configuration

```yaml
ispa.api:
    app:
        ruian:
            http:
                base_uri: http://ruian.example.com/api/
```

### Endpoints

@todo

### Cpost

### Configuration

```yaml
ispa.api:
    app:
        cpost:
            http:
                base_uri: http://adminus.example.com/api/
                auth: [dreplech, dreplech]
            config:
              tmp_dir: '../../some/tmp/dir/path/'
```

### Endpoins

@todo


### DBD

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

### Endpoints

@todo
