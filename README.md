PHP Coroutine
======

A lightweight library to implement coroutine by yield & Generator.

## Requirements

* PHP 5.5 or later

## Installation via Composer([packagist](https://packagist.org/packages/hhxsv5/php-coroutine))

```BASH
composer require "hhxsv5/php-coroutine:~1.0" -vvv
```

## Usage
### Run demo

```PHP
include '../vendor/autoload.php';

use Hhxsv5\Coroutine\Scheduler;

function task1()
{
    for ($i = 1; $i <= 5; ++$i) {
        echo "Task1: {$i}", PHP_EOL;
        yield;
    }
}

function task2()
{
    for ($i = 1; $i <= 5; ++$i) {
        echo "Task2: {$i}", PHP_EOL;
        yield;
    }
}

$scheduler = new Scheduler();

$scheduler->createTask(task1());
$scheduler->createTask(task2());

$scheduler->run();
```

## License

[MIT](https://github.com/hhxsv5/php-coroutine/blob/master/LICENSE)
