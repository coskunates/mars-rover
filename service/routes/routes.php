<?php

// Routes of the project

use App\System\Router;

Router::add('get', '/plateaus/([0-9]*)', 'App\Controllers\PlateauController::get');
Router::add('get', '/v2/plateaus/([0-9]*)', 'App\Controllers\V2\PlateauController::get');
Router::add('post', '/plateaus', 'App\Controllers\PlateauController::store');
Router::add('get', '/rovers/([0-9]*)', 'App\Controllers\RoverController::get');
Router::add('post', '/rovers', 'App\Controllers\RoverController::store');
Router::add('put', '/rovers/([0-9]*)/move', 'App\Controllers\RoverController::move');
Router::add('get', '/rovers/([0-9]*)/state', 'App\Controllers\RoverController::state');
