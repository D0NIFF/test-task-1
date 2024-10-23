<?php

include __DIR__ . '/vendor/autoload.php';

use App\Middlewares\Configuration;

\App\Middlewares\Configuration::initialize();


include __DIR__ . '/routes.php';