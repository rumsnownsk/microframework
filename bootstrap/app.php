<?php


define("BASEPATH", dirname(__DIR__));

$app = \App\System\App::getInstance(BASEPATH);
$config = new App\System\Config\Config('config');
$config->addConfig('database.yaml');
$config->addConfig('app.yaml');

//dd('ba');
$app->add('config', $config);

if (config('system.orm')){
    $orm = new \App\System\Database\Orm(config('database'));
    $app->add('orm', $orm);
}


return $app;
