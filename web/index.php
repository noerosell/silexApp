<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/get/tweets','App\\defaultController::getTweets');
$app['debug'] = true;

$app->run();
