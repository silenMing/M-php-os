<?php
class events_quene{

    static private $__instance = null;

    static private $__config = null;

    private $__controller = null;

    static private function __init()
    {
        if (!isset(self::$__config))
        {
            self::$__config['queues']   = (array)config::get('queue.queues', array());
            self::$__config['bindings'] = (array)config::get('queue.bindings', array());
            self::$__config['action']   = (array)config::get('queue.action', array());
        }
    }

    /**
     *实例化，解耦
     */
    static public function instance()
    {
        if (!isset(self::$__instance))
        {
            self::$__instance = new events_quene;
        }
        return self::$__instance;
    }

    public function publish($exchange_name, $worker, $params=array())
    {
        $queues = $this->__get_publish_queues($exchange_name);
        foreach($queues as $queue_name)
        {
            $queue_data = array(
                'queue_name' => $queue_name,
                'worker' => $worker,
                'params' => $params,
            );
            $this->get_controller()->publish($queue_name, $queue_data);
        }
        return true;
    }

    static private function __get_publish_queues($exchange_name)
    {
        if (!isset(self::$__config['bindings'][$exchange_name]))
        {
            $default_publish_queue = config::get('queue.default_publish_queue');
            return array($default_publish_queue);
        }
        return self::$__config['bindings'][$exchange_name];
    }

    public function get_controller()
    {
        return $this->__controller;
    }
}