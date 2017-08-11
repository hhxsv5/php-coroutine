<?php
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