<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/get/{quantity}/tweets/from/{tweeterUser}','App\\Api\defaultController::getTweets')
    ->assert('quantity','\d+')
    ->assert('tweeterUser','^@.+');

$app['twiter.oauth.connection']=function(){
    return new \Abraham\TwitterOAuth\TwitterOAuth(
        \App\Infrastructure\Persistence\TweeterRestApiRepository::$_TWEETER_CONSUMER_KEY,
        \App\Infrastructure\Persistence\TweeterRestApiRepository::$_TWEETER_CONSUME_SECRET,
        \App\Infrastructure\Persistence\TweeterRestApiRepository::$_TWEETER_ACCESS_TOKEN,
        \App\Infrastructure\Persistence\TweeterRestApiRepository::$_TWEETER_ACCESS_TOKEN_SECRET
    );
};
$app['get.tweets.from.tweeter.user']= $app->factory(function($app){
    return new \App\Interactors\GetTweetsFromTweeterUserUseCase(
        new \App\Infrastructure\Persistence\TweeterRestApiRepository($app['twiter.oauth.connection']),
        new \App\Api\TweetsJsonPresenter()
    );
});

$app['debug'] = true;

$app->run();
