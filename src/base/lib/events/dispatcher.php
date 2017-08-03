<?php

class base_events_dispatcher{
    /**
     * The registered event listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * The sorted event listeners.
     *
     * @var array
     */
    protected $sorted = [];

    /**
     * The event firing stack.
     *
     * @var array
     */
    protected $firing = [];

    /**
     * 异步事件任务指定的队列
     *
     * @var array
     */
    protected $queues = [];


    /**
     * 是否需要初始化事件任务
     */
    protected $initEvents = true;


    /**
     * Register an event listener with the dispatcher.
     *
     * @param  string|array  $events
     * @param  mixed  $listener
     * @param  string $sync   sync 同步｜async 异步
     * @param  int  $priority
     * @param  string $queue 如果为异步可指定执行的队列
     * @return void
     */
    public function listen($events, $listener, $sync='sync', $priority = 0, $queue)
    {
        foreach ((array) $events as $event)
        {
            //目前闭包监听只支持同步
            if(is_string($listener) )
            {
                list($class, $method) = $this->parseClassCallable($listener);
                $objClass = new $class();
            }

            if( $sync == 'async' && $this->__listenerIsSupportAsync($objClass) )
            {
                $this->queues[$listener] = $queue ? $queue : 'system_tasks_events';
                $this->listeners[$event]['async'][$priority][] = $listener;
            }
            else
            {
                if( is_string($listener) )
                {
                    $this->listeners[$event]['sync'][$priority][] = $this->createClassListener($objClass, $method);
                }
                else
                {
                    $this->listeners[$event]['sync'][$priority][] = $listener;
                }
            }

            unset($this->sorted[$event]);
        }
    }

    /**
     *  返回listener的处理类和处理方法
     *
     * @param  string  $listener
     * @return array
     */
    protected function parseClassCallable($listener)
    {
        $segments = explode('@', $listener);

        return [$segments[0], count($segments) == 2 ? $segments[1] : 'handle'];
    }

    /**
     * listener是否支持异步调用
     */
    private function __listenerIsSupportAsync($objClass)
    {
        if( $objClass instanceof base_events_interface_queue )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 根据class创建监听事件
     */
    public function createClassListener($objClass, $method)
    {
        return function () use ($objClass, $method) {
            return call_user_func_array(
                [$objClass, $method], func_get_args()
            );
        };
    }
}