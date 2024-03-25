Metrics Power Component
=============================

![Workflow Build Status](https://github.com/fractalzombie/frzb-metrics-power/actions/workflows/ci.yml/badge.svg?event=push)

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

use FRZB\Component\MetricsPower\Attribute\Metrical;use FRZB\Component\MetricsPower\Attribute\PrometheusOptions;

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
