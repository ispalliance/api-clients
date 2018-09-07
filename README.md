# ISPA API(s)

## Install

```
composer require ispa/api-clients
```

## Versions

| State       | Version | Branch   | PHP      |
|-------------|---------|----------|----------|
| dev         | `^0.1`  | `master` | `>= 7.2` |

## Overview

@todo


## API

### ARES

#### Get subject

	<?php
	
	use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
	use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
	
	try {
		$subject = $api->ares->subject->get('IDENTIFICATION_NUMBER');
	} catch (InvalidIdNumberException $e) {
		// Do something
	} catch (SubjectNotFoundException $e) {
		// Do something
	}


#### Get subjects

	<?php
	
	use ISPA\ApiClients\App\Ares\Exception\Runtime\TooManySubjectsException;
	
	try {
		$subjects = $api->ares->subject->getAll('NAME');
	} catch (TooManySubjectsException $e) {
		// Do something
	}


#### Get address

	<?php
	
	use ISPA\ApiClients\App\Ares\Exception\Runtime\InvalidIdNumberException;
	use ISPA\ApiClients\App\Ares\Exception\Runtime\SubjectNotFoundException;
	
	try {
		$subject = $api->ares->address->get('IDENTIFICATION_NUMBER');
	} catch (InvalidIdNumberException $e) {
		// Do something
	} catch (SubjectNotFoundException $e) {
		// Do something
	}
