<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;
use Viabo\Backend\ViaboKernel;

require dirname(__DIR__) . '/../../../vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/../../../.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
}

$kernel = new ViaboKernel($_SERVER['APP_ENV'] , (bool)$_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();

$response = $kernel->handle($request);

if ($response->isNotFound()) {
    header('Location: /', true, 302);
    exit();
}
$response->send();
$kernel->terminate($request , $response);
