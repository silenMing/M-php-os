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


/*
 * 测试http
 * */
// 请求的URI (e.g. /about)
$request->getPathInfo();

// 分别得到GET参数或POST参数
$request->query->get('foo'); // GET
$request->request->get('bar', '如何没有bar的默认值'); // POST

// 得到服务器变量
$request->server->get('HTTP_HOST');

// 得到上传文件对象
$request->files->get('foo');

// 得到cookie值
$request->cookies->get('PHPSESSID');

// 得到http请求头信息
$request->headers->get('host');
$request->headers->get('content_type');

$request->getMethod();    // GET, POST, PUT, DELETE, HEAD
$request->getLanguages(); // 得到客户端接收语言数组