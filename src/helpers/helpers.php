<?php

if (!function_exists('app')) {
    function app()
    {
        return App\System\App::getInstance();
    }
}
if (!function_exists('config')) {
    function config($keyValue)
    {
        $config = app()->get('config');
        return $config->get($keyValue);
    }
}
