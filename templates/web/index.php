<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../src/AppKernel.php';

$kernel = new AppKernel(getenv('SYMFONY_ENV') ?: 'dev', getenv('SYMFONY_DEBUG') !== '0');
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
