# Helthe Mandrill Bundle [![Build Status](https://travis-ci.org/helthe/MandrillBundle.png?branch=master)](https://travis-ci.org/helthe/MandrillBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/helthe/Mandrill/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/helthe/MandrillBundle/?branch=master)

Helthe Mandrill Bundle integrates the [Helthe Mandrill Component](https://github.com/helthe/Mandrill)
with your Symfony2 application.

## Installation

### Step 1: Add package requirement in Composer

#### Manually

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "helthe/mandrill-bundle": "dev-master"
    }
}
```

#### Using the command line

```bash
$ composer require 'helthe/mandrill-bundle=dev-master'
```

### Step 2: Register the bundle in the kernel

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Helthe\Bundle\MandrillBundle\HeltheMandrillBundle(),
    );
}
```

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/MandrillBundle/issues/new).
