<?php
/**
 * Created by PhpStorm.
 * User: silen
 * Date: 2017/2/5
 * Time: 22:59
 */
require_once  __DIR__ .'/vendor/autoload.php';

$request= \Symfony\Component\HttpFoundation\Request::createFromGlobals();

//create request object
$input = $request->get('name','world');

$respons = new \Symfony\Component\HttpFoundation\Response(sprintf(
    'Hello %s',
    htmlspecialchars($input,ENT_QUOTES,'utf-8')
));

$request->send();