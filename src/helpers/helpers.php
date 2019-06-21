<?php

if (!function_exists('app')){
    function app(){
        return App\System\App::getInstance();
    }
}
