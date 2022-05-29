<?php

use josegonzalez\Dotenv\Loader;

/** Loads environment variables from .env file **/
$envfile = __DIR__ . '/../../.env';
$dotenv = new Loader($envfile);

/** Parses the .env file and loads the environment variables **/
$dotenv->parse();
$dotenv->putenv();
$dotenv->define();
