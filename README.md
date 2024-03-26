Metrics Power Component
=============================

![Workflow Build Status](https://github.com/fractalzombie/frzb-metrics-power/actions/workflows/ci.yml/badge.svg?event=push)
[![Coverage Status](https://coveralls.io/repos/github/fractalzombie/frzb-metrics-power/badge.svg?branch=main)](https://coveralls.io/github/fractalzombie/frzb-metrics-power?branch=main)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=fractalzombie_frzb-metrics-power&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=fractalzombie_frzb-metrics-power)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fractalzombie/frzb-metrics-power/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/fractalzombie/frzb-metrics-power/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/fractalzombie/frzb-metrics-power/badges/build.png?b=main)](https://scrutinizer-ci.com/g/fractalzombie/frzb-metrics-power/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/fractalzombie/frzb-metrics-power/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

The `Metrics Power Component` allows make your application able to metric

Installation
------------
The recommended way to install is through Composer:

```
composer require frzb/metrics-power
```

It requires PHP version 8.1 and higher.

Usage of `#[Metrical]`
-----
`#[Metrical]` will automatically create and collect metrics for your messages

Example
-------

```php
<?php

use FRZB\Component\MetricsPower\Attribute\Metrical;
use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;

#[Metrical(
    new PrometheusOptions(
        'some_topic',
        'CreateUserMessage',
        'Total of user messages',
        ['label'],
        ['total']
    ),
)]
final class CreateUserMessage {
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}
}
```

Resources
---------
* [License](https://github.com/fractalzombie/frzb-metrics-power/blob/main/LICENSE.md)

![Alt](https://repobeats.axiom.co/api/embed/854420235662fb76f86b6e5c72b4eb083185916e.svg "Metrics Power Component")
