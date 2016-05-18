[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/?branch=develop)

FOACronBundle - cron manager for Akeneo
=======================================

## Overview
This bundle is adaptation of [BCCCronManagerBundle](https://github.com/michelsalib/BCCCronManagerBundle) to be compatible
with Akeneo PIM. Also it has some code quality improvements.

## Installation

1) Install bundle using [Composer](https://getcomposer.org/download/):

```
    composer install friendsofakeneo/cron-bundle
```

2) Enable the bundle in `AppKernel.php` file:
```php
    public function registerBundles()
    {
        $bundles = [
            ...
            new FOA\CronBundle\FOACronBundle(),
        ];
        ...
```
3) Register bundle routes in:


## Usage

### TODO
