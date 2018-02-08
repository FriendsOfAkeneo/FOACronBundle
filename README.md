[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/FriendsOfAkeneo/FOACronBundle/?branch=develop)
[![Build Status](https://travis-ci.org/FriendsOfAkeneo/FOACronBundle.svg?branch=2-compatibility)](https://travis-ci.org/FriendsOfAkeneo/FOACronBundle)

FOACronBundle - easy cron management from Akeneo dashboard
=======================================

# Overview

This bundle is adaptation of awesome [BCCCronManagerBundle](https://github.com/michelsalib/BCCCronManagerBundle) for Akeneo.
This version provides some quality improvements and UI compatible with Akeneo.

# Requirements

| FOACronBundle | Akeneo PIM Edition |
|:-------------:|:------------------:|
| v1.0.*        | v1.5.*             |
| v1.1.*        | v1.6.*             |
| v1.2.*        | v1.7.*             |
| v1.3.*        | v2.*.*             |

# Installation

1) Install bundle using [Composer](https://getcomposer.org/download/):

```bash
    composer require friendsofakeneo/cron-bundle
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

# Usage

1) Configure access for users who can manage cron tasks in 'System->Roles->Update->Roles Management'

@TODO add screen after compatibility finished

Now cron management should be available by 'System->Cron Management'.

@TODO add screen after compatibility finished
