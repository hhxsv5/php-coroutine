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

- PHP 5.5+

```PHP
include '../vendor/autoload.php';

use Hhxsv5\Coroutine\Scheduler;

$start = microtime(true);
/**
 * @param mixed & $return
 * @return Generator
 */
function task1(&$return)
{
    echo 'task1:start ', microtime(true), PHP_EOL;
    $return = yield file_get_contents('http://www.weather.com.cn/data/cityinfo/101270101.html');
    echo 'task1:end ', microtime(true), PHP_EOL;
}

/**
 * @param mixed & $return
 * @return Generator
 */
function task2(&$return)
{
    echo 'task2:start ', microtime(true), PHP_EOL;
    $return = yield file_get_contents('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=yourtoken');
    echo 'task2:end ', microtime(true), PHP_EOL;
}

$scheduler = new Scheduler();

$t1 = task1($return1);
$t2 = task2($return2);


$scheduler->createTask($t1);
$scheduler->createTask($t2);

$scheduler->run();

var_dump($return1, $return2);

$end = microtime(true) - $start;
echo $end;
```

- PHP7+ 

```PHP
include '../vendor/autoload.php';

use Hhxsv5\Coroutine\Scheduler;

$start = microtime(true);
/**
 * @return Generator
 */
function task1()
{
    echo 'task1:start ', microtime(true), PHP_EOL;
    $ret = yield file_get_contents('http://www.weather.com.cn/data/cityinfo/101270101.html');
    echo 'task1:end ', microtime(true), PHP_EOL;
    return $ret;
}

/**
 * @return Generator
 */
function task2()
{
    echo 'task2:start ', microtime(true), PHP_EOL;
    $ret = yield file_get_contents('https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=yourtoken');
    echo 'task2:end ', microtime(true), PHP_EOL;
    return $ret;
}

$scheduler = new Scheduler();

$t1 = task1();
$t2 = task2();

$scheduler->createTask($t1);
$scheduler->createTask($t2);

$scheduler->run();

var_dump($t1->getReturn(), $t2->getReturn());//PHP 7+

$end = microtime(true) - $start;
echo $end;
```

## License

[MIT](https://github.com/hhxsv5/php-coroutine/blob/master/LICENSE)
