<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/get/{quantity}/tweets/from/{tweeterUser}','App\\Api\defaultController::getTweets')
    ->assert('quantity','\d+')
    ->assert('tweeterUser','^@.+');

$app['get.tweets.from.tweeter.user']= $app->factory(function(){
    return new \App\Interactors\GetTweetsFromTweeterUserUseCase(
        new \App\Infrastructure\Persistence\TweeterRestApiRepository(),
        new \App\Api\TweetsJsonPresenter()
    );
});

$app['debug'] = true;

$app->run();
