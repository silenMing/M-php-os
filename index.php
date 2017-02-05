<?php
/**
 * Created by PhpStorm.
 * User: silen
 * Date: 2017/2/5
 * Time: 22:59
 */

require_once __DIR__.'/init.php';

$input = $request->get('name', 'World');

$response->setContent(sprintf(
    'Hello %s',
    htmlspecialchars($input, ENT_QUOTES, 'UTF-8')
));
$response->send();