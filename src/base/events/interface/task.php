<?php
/**
 * Created by PhpStorm.
 * User: zhangming
 * Date: 2017/8/25
 * Time: 15:19
 */

interface base_events_interface_task
{
    //执行计划任务的方法
    function exec($params=null);
}