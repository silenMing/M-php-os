<?php
/**
 * Created by PhpStorm.
 * User: zhangming
 * Date: 2017/8/14
 * Time: 16:00
 */
class testSync{

    public function handle($data)
    {
        echo '测试事件同步执行参数'."\n";
        print_r($data);

        $str = '测试事件同步执行完成';
        echo $str."\n\n";

        return true;
    }
}