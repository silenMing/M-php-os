<?php


/*
|--------------------------------------------------------------------------
| 添加alias列表到ClassLoader
|--------------------------------------------------------------------------
|
| 添加alias列表到ClassLoader
|
*/
$aliases = require __DIR__.'/aliases.php';
\ClassLoader::addAliases($aliases);

