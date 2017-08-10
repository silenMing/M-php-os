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
}