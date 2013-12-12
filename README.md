Twig apply_filter
================

This filter allows you to call dynamic filters in twig.

[![Build Status](https://travis-ci.org/marcj/twig-apply_filter-bundle.png?branch=master)](https://travis-ci.org/marcj/twig-apply_filter-bundle)
Examples
-------

```twig
{{ set filters = 'upper|nl2br' }}

{{ value|apply_filter(filters) }}

{{ value|apply_filter("default('abc')|json_encode") }}

```


Installation
------------

### Install via composer

```bash
composer.phar require marcj/twig-apply_filter-bundle
```

### Activate bundle

Open your AppKernel.php

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new MJS\TwigApplyFilter\MJSTwigApplyFilterBundle(),
    );
}
```