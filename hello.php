<?php
/**
 * Created by PhpStorm.
 * User: silen
 * Date: 2017/2/6
 * Time: 22:54
 */

$input = $request->get('name', 'World');
$response->setContent(sprintf(
    'Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')
));