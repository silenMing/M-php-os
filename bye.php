<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/2/5
 * Time: 23:47
 */
require_once __DIR__.'/init.php';

$response->setContent('Goodbye!');
$response->send();