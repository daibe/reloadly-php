ReloadlyPHP
===================
----------------------------------
[![Latest Stable Version](https://poser.pugx.org/phpunit/phpunit/v)](//packagist.org/packages/phpunit/phpunit)
[![Total Downloads](https://poser.pugx.org/phpunit/phpunit/downloads)](//packagist.org/packages/phpunit/phpunit)
[![License](https://poser.pugx.org/phpunit/phpunit/license)](//packagist.org/packages/phpunit/phpunit)


## Documentation

The documentation for the Reloadly API can be found [here][apidocs].

The PHP library documentation can be found [here][libdocs].

## Versions

`reloadly-php` uses a modified version of [Semantic Versioning](https://semver.org) for all changes. 

## Overview

### Supported PHP Versions

This library supports the following PHP implementations:

* PHP 7.2
* PHP 7.3
* PHP 7.4

### Installation

You can install **reloadly-php** via composer or by downloading the source.

#### Via Composer:

**reloadly-php** is available on Packagist as the
[`daibe/reloadly-php`](https://packagist.org/packages/daibe/reloadly-php) package:

```
composer require daibe/reloadly-php
```

Alternatively, you can specify the **reloadly-php** package as a dependency in 
your project’s existing **composer.json** file:

```json
 {
   "require": {
     "daibe/reloadly-php": "^1.0.3"
   }
}
```

After installing, you need to require Composer’s autoloader:

```php
<?php

    require __DIR__.'/vendor/autoload.php';

```
You can find out more on how to install Composer, configure autoloading, 
and other best-practices for defining dependencies at [`getcomposer.org`](https://getcomposer.org/).

### Quickstart

#### Instantiation

```php
<?php

    use ReloadlyPHP\Client;
    
    // Instantiate ReloadlyPHP 
    $reloadly = new Client('yourClientId', 'yourClientSecret');
```

Sandbox or live production mode

```php
<?php

    use ReloadlyPHP\Client;

    $isProd = (bool) App::environment('production'); // Laravel
    
    // Instantiate ReloadPHP 
    $reloadly = new Client('yourClientId', 'yourClientSecret', $isProd);
```


#### Check balance

```php
// Check your account's balance using Reloadly's REST API and PHP
<?php

    use ReloadlyPHP\Client;

    $client_id      = 'ACXXXXXX'; // Your developer client secret from www.reloadly.com/dashboard
    $client_secret  = 'YYYYYY'; // Your developer client password from www.reloadly.com/dashboard
    
    try {
    
        $reloadly   = new Client($client_id, $client_secret);
        $balance    = $reloadly->getBalance();
    
        echo '<pre>';
        echo sprintf("Amount: <strong>%s</strong> <br/>", $balance->getBalance());
        echo sprintf("Currency name: <strong>%s</strong> <br/>", $balance->getCurrencyName());
        echo sprintf("Currency code: <strong>%s</strong> <br/>", $balance->getCurrencyCode());
        echo '</pre>';
        

    } catch (Exception $e) {
        echo "Exception: ".$e->getMessage();
    }
```


#### Get countries

```php
<?php

    try {    
        $operators = $reloadly->getOperators();
        
        echo '<pre>';
        foreach ($operators as $operator) {
            echo sprintf("Operator name: <strong>%s</strong> <br/>", $operator->getName());
            echo sprintf("Operator ID: <strong>%d</strong> <br/>", $operator->getOperatorId());
        }
        echo '</pre>';
    
    } catch (Exception $e) {
        // ... 
    }
```


#### Get foreign exchange rates

```php
<?php

    try {    
        
        $fxRate = $reloadly->getFxRate(506, 1);
    
        if ($fxRate) {
            echo sprintf("Name: <strong>%s</strong> <br/>", $fxRate->getName());
            echo sprintf("FX Rate: <strong>%s</strong> <br/>", $fxRate->getFxRate());
            echo sprintf("Currency Code: <strong>%s</strong> <br/>", $fxRate->getCurrencyCode());
            echo sprintf("Operator ID: <strong>%d</strong> <br/>", $fxRate->getOperatorId());
        }
    
    } catch (Exception $e) {
        // ... 
    }
```

## Contributing
Anyone can contribute to improve or fix ReloadlyPHP, to do so you can either report an issue (a bug, an idea...)
or fork the repository, perform modifications to your fork then request a merge.


[apidocs]: https://developers.reloadly.com/
[libdocs]: https://daibe.github.io/reloadly-php