<?php

class base_redis_redis implements events_interface_adapter{

    /**
     * 创建执行队列的有效时间
     *
     * @var int|null
     */
    protected $expire = 3600;

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
        redis::scene('queue')->rpush($queueName, $payload);
        return Arr::get(json_decode($payload, true), 'id');
    }

    /**
     * 获取一个队列任务ID
     *
     * @param string $queueName
     * @return mixed 队列任务数据
     */
    public function get($queueName){
        if (! is_null($this->expire) )
        {
            $this->migrateAllExpiredJobs($queueName);
        }

        $objectRedis = redis::scene('queue');
        $objectRedis->loadScripts('queueGet');

        $queueData = $objectRedis->queueGet($queueName, 'queue:'.$queueName.':reserved', time() + $this->expire);

        if( ! empty($queueData) )
        {
            return new system_queue_message_redis($this, $queueData, $queueName);
        }

        return false;
    }

    /**
     * 确认消息已经被消费.
     *
     * @param  string  $queueData
     * @return void
     */
    public function ack($queueName, $queueData){
        return redis::scene('queue')->zrem($queueName.':reserved', $queueData);
    }

    /**
     * 清空一个队列
     *
     * @param string $queue
     */
    public function purge($queueName){
        redis::scene('queue')->ltrim($queueName,-1,0);
    }

    public function is_end($queueName){

    }

    /**
     * 将所有延时队列或者处理超时的队列重新加入到队列中
     *
     * @param  string  $queue
     * @return void
     */
    protected function migrateAllExpiredJobs($queueName)
    {
        $this->migrateExpiredJobs($queueName.':delayed', $queueName);

        $this->migrateExpiredJobs($queueName.':reserved', $queueName);
    }

    /**
     * 将延时队列或者处理超时的队列重新加入到执行队列中
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    public function migrateExpiredJobs($from, $to)
    {
        $from = $from;
        $to = 'queue:'.$to;

        $objectReids = redis::scene('queue');
        $objectReids->loadScripts('queueMigrate');

        $v = $objectReids->queueMigrate($from, $to, time());


        return $v;
    }



}