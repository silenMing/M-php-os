<?php
/**
 * Created by PhpStorm.
 * User: zhangming
 * Date: 2017/8/14
 * Time: 16:01
 */
class testAsync implements base_events_interface_queue{

    public function test($data)
    {
        $str = '测试事件异步执行';
        echo $str;
        error_log(var_export($str,1)."\n",3,DATA_DIR.'/log.log');
    }

}