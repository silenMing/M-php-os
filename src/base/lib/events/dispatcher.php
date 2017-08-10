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

    /**
     * Fire an event and call the listeners.
     *
     * @param  string|object  $eventName
     * @param  array $params
     * @param  bool  $halt
     * @return array|null
     */
    public function fire($eventName, $params, $halt = false)
    {
        $this->__preInitEvents($eventName);

        $responses = [];

        $this->firing[] = $eventName;

        if( ! is_array( $params ) )
        {
            $params = [$params];
        }

        $listeners = $this->getListeners($eventName);

        //执行同步listeners
        foreach ($listeners['sync'] as $key=>$listener)
        {
            $response = call_user_func_array($listener, $params );

            if (! is_null($response) && $halt)
            {
                array_pop($this->firing);
                return $response;
            }

            if ($response === false)
            {
                break;
            }

            $responses[] = $response;
        }

        $this->__fireAsync($eventName, $params, $listeners['async']);

        array_pop($this->firing);

        //执行完一个事件后，重置需要初始化
        $this->isInitEvents(true);

        return $responses;
    }

    /**
     * Get the event that is currently firing.
     *
     * @return string
     */
    public function firing()
    {
        return last($this->firing);
    }

//    private function __preInitEvents($eventName)
//    {
//        if( $this->initEvents )
//        {
//            $EventService = kernel::single('base_events_service');
//            $EventService->setListens($eventName)->boot();
//        }
//    }

    /**
     * Get all of the listeners for a given event name.
     *
     * @param  string  $eventName
     * @return array
     */
    public function getListeners($eventName)
    {
        if (! isset($this->sorted[$eventName]))
        {
            $this->sortListeners($eventName);
        }

        return $this->sorted[$eventName];
    }
}