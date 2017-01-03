[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/?branch=develop)

FOACronBundle - easy cron management from Akeneo dashboard
=======================================

## Overview

This bundle is adaptation of awesome [BCCCronManagerBundle](https://github.com/michelsalib/BCCCronManagerBundle) for Akeneo.
This version provides some quality improvements and UI compatible with Akeneo.

## Installation

1) Install bundle using [Composer](https://getcomposer.org/download/):

```bash
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
3) Register bundle routes in `app/config/routing.yml`:
```yml
FOACronBundle:
    resource: '@FOACronBundle/Resources/config/routing.yml'
    prefix:   /cron-manager
```

## Usage

1) Configure access for users who can manage cron tasks in 'System->Users Management->Roles'

![Roles Management](https://raw.githubusercontent.com/username/projectname/branch/path/to/img.png)

Now cron management should be available by 'System->Cron Management'.

![Cron Management board](https://raw.githubusercontent.com/username/projectname/branch/path/to/img.png)


### TODO
1) Update UI to be more beauty and understandable;
