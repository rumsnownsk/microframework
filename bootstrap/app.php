<?php


define("BASEPATH", dirname(__DIR__));

$app = \App\System\App::getInstance(BASEPATH);

$config = new App\System\Config\Config('config');
$config->addConfig('database.yaml');

$app->add('config', $config);

// dd($config->get('database.dbname'));

return $app;
