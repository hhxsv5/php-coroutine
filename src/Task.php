<?php

namespace Hhxsv5\Coroutine;

class Task
{
    protected $id;
    protected $coroutine;
    protected $sendValue;
    protected $beforeFirstYield = true;

    public function __construct($id, \Generator $coroutine)
    {
        $this->id = $id;
        $this->coroutine = $coroutine;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSendValue($sendValue)
    {
        $this->sendValue = $sendValue;
    }

    public function run()
    {
        if ($this->beforeFirstYield) {
            $this->beforeFirstYield = false;
            return $this->coroutine->current();
        } else {
            $retValue = $this->coroutine->send($this->sendValue);
            $this->sendValue = null;
            return $retValue;
        }
    }

    public function isFinished()
    {
        return !$this->coroutine->valid();
    }
}