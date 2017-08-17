<?php

namespace Hhxsv5\Coroutine;


class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskQueue;

    public function __construct()
    {
        $this->taskQueue = new \SplQueue();
    }

    public function createTask(\Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->schedule($task);
        return $tid;
    }

    public function schedule(Task $task)
    {
        $this->taskQueue->enqueue($task);
    }

    public function run()
    {
        while (!$this->taskQueue->isEmpty()) {
            /**
             * @var Task $task
             */
            $task = $this->taskQueue->dequeue();
            $task->run();

            if ($task->isFinished()) {
                //Finished
            } else {
                $this->schedule($task);
            }
        }
    }
}