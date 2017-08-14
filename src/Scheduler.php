<?php

namespace Hhxsv5\Coroutine;


class Scheduler
{
    protected $maxTaskId = 0;
    protected $taskMap   = []; // taskId => task
    protected $taskQueue;

    /**
     * @var array IO queue that waiting to read [resourceID => [socket, tasks]].
     */
    protected $waitingForRead = [];
    /**
     * @var array IO queue that waiting to write [resourceID => [socket, tasks]].
     */
    protected $waitingForWrite = [];

    public function __construct()
    {
        $this->taskQueue = new \SplQueue();
    }

    public function createTask(\Generator $coroutine)
    {
        $tid = ++$this->maxTaskId;
        $task = new Task($tid, $coroutine);
        $this->taskMap[$tid] = $task;
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
                unset($this->taskMap[$task->getId()]);
            } else {
                $this->schedule($task);
            }
        }
    }
}