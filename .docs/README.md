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

- lotus
- crm
- nms
- pedef

```yaml
ispa.api:
    app:
        lotus:
            guzzle:
                base_uri: http://lotus.example.com/api/v1/

        crm:
            guzzle:
                base_uri: http://adminus.example.com/api/v1/
                    defaults:
                        auth: [username, password]

        nms:
            guzzle:
                base_uri: http://nms.example.com/api/v1/

        pedef:
            guzzle:
                base_uri: http://pedef.example.com/api/v1/
```

Each application has `guzzle` key for configure their Guzzle client, 
take a look at [Guzzle doc](https://guzzle.readthedocs.io/en/latest/quickstart.html).

You could also disable client

```yaml
ispa.api:
    app:
        lotus: false
```

## Usage

There are many ways how to use this aggregated API clients.

### ApiManager

This is high-level managed API layer.

```php
/** @var ApiManager @inject */
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


At this time we support these applications:

- lotus

### ApiClientLocator

This is middle-level way how to manage our APIs.

```php
/** @var ApiClientLocator @inject */
public $api;

public function magic(): void
{
    $users = $this->api->lotus->get("users");
}
```

It's collection of API clients with preconfigured Guzzle clients inside. There are
some basic methods on it `get`, `post`, `put`,  `patch`, `head`, `delete`.

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
