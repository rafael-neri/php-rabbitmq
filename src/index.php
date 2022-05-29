<?php

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush(true);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config/Errors.php';
require __DIR__ . '/config/DotEnv.php';
require __DIR__ . '/config/Routes.php';
