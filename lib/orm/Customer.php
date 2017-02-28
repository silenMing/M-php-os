<?php
/**
 * Created by PhpStorm.
 * User: zhangming
 * Date: 2017/2/28
 * Time: 18:07
 */

class Customer extends ActiveRecord {
    protected static  $table = 'userdb';

    protected static  $field = array(
        'id'=>'int',
        'name' => 'varchar',
    );
}
