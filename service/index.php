<?php

use App\System\App;
use App\System\Config;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/routes/routes.php';

$app = new App();
$app->run();