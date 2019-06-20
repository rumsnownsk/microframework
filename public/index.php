<?php

require "../vendor/autoload.php";
//use Carbon\Carbon;

$app = require_once __DIR__."/../bootstrap/app.php";

$app->run();

//printf("Right now is %s", Carbon::now()->toDateTimeString());
