<?php

namespace Hhxsv5\Coroutine;

class Task
{
    protected $id;
    protected $coroutine;
    protected $exception;

    public function __construct($id, \Generator $coroutine)
    {
        $this->id = $id;
        $this->coroutine = $coroutine;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    public function run()
    {
        $retValue = $this->coroutine->current();
        //TODO: 嵌套协程
        //TODO: 异常处理
        $this->coroutine->send($retValue);
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}