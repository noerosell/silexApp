<?php
use App\Infrastructure\persistence\PredisCacheClient;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/predis/predis/autoload.php';

$app = new Silex\Application();

$app['predis']=function($app){
    try{

       $predisClient= new Predis\Client([
           'scheme' =>'tcp',
           'host' => '127.0.0.1',
           'port' => 6379
       ]);
        return new PredisCacheClient($predisClient);
    }catch(\Throwable $t)
    {
    }

};
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
        new \App\Infrastructure\Persistence\TweeterRestApiRepository($app['twiter.oauth.connection'],$app['predis']),
        new \App\Api\TweetsJsonPresenter()
    );
});

$app['debug'] = true;

$app->run();
