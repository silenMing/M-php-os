<?php

class system_queues_redis implements events_interface_adapter{

    /**
     * 创建一个队列任务
     *
     * @param  string  $queueName 队列标示
     * @param  array   $data 执行队列参数
     * @return mixed
     */
    public function publish($queueName, $queueData ){

    }


    /**
     * 将队列保存到redis
     *
     * @param  string  $payload
     * @param  string  $queue
     * @return mixed
     */
    public function pushRaw($payload, $queueName ){

    }

    /**
     * 获取一个队列任务ID
     *
     * @param string $queueName
     * @return mixed 队列任务数据
     */
    public function get($queueName){

    }

    /**
     * 确认消息已经被消费.
     *
     * @param  string  $queueData
     * @return void
     */
    public function ack($queueName, $queueData){

    }

    /**
     * 清空一个队列
     *
     * @param string $queue
     */
    public function purge($queueName){

    }

    public function is_end($queueName){

    }

}