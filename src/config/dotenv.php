<?php

use josegonzalez\Dotenv\Loader;

$envfile = __DIR__ . '/../.env';
$dotenv = new Loader($envfile);
$dotenv->parse();
$dotenv->putenv();
$dotenv->define();