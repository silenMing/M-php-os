<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/2/5
 * Time: 23:46
 */

require_once __DIR__.'/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();