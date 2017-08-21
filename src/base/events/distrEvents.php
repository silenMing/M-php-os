<?php
/**
 * 将事件的listeners分发到对于执行的队列
 */
class base_events_distrEvents {

    public function exec($params=null)
    {
        $queueParams['eventParams'] = $params['eventParams'];
        $queueParams['eventName'] = $params['eventName'];
        foreach( $params['listeners'] as $key=>$listener )
        {
            $queue = $params['queues'][$listener];
            $queueParams['listener'] = $listener;
            events_quene::instance()->publish($queue, $queue, $queueParams);
        }
    }

}