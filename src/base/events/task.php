<?php

/**
 * 默认执行事件监听类
 */
class base_events_task extends base_events_abstract_task implements base_events_interface_task{

    public function exec($params=null)
    {
        event::push($params['eventName'], $params['listener'], $params['eventParams']);
    }
}