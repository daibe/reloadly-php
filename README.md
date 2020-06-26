# reloadly-php

## Documentation

The documentation for the Reloadly API can be found [here][apidocs].

The PHP library documentation can be found [here][libdocs].

## Versions

`reloadly-php` uses a modified version of [Semantic Versioning](https://semver.org) for all changes. 

### Supported PHP Versions

This library supports the following PHP implementations:

* PHP 7.2
* PHP 7.3
* PHP 7.4

## Installation

You can install **reloadly-php** via composer or by downloading the source.

### Via Composer:

**reloadly-php** is available on Packagist as the
[`daibe/reloadly-php`](https://packagist.org/packages/daibe/reloadly-php) package:

```
composer require daibe/reloadly-php
```

## Quickstart

### Check balance

```php
// Check your account's balance using Reloadly's REST API and PHP
<?php
$client_id = "ACXXXXXX"; // Your developer client secret from www.reloadly.com/dashboard
$client_secret = "YYYYYY"; // Your developer client password from www.reloadly.com/dashboard

$client = new ReloadlyPHP\Client($client_id, $client_secret);
$balance = $client->getBalance();

print $balance->getBalance();
```


[apidocs]: https://developers.reloadly.com/
[libdocs]: https://daibe.github.io/reloadly-php