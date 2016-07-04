<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 16:28
 */

namespace App\Api;


use App\Domain\TweeterUser;
use App\Domain\TweetsPresenter;

class TweetsJsonPresenter implements TweetsPresenter
{
    public function write(TweeterUser $tweeterUser)
    {

        $parsedResult=[];
        foreach($tweeterUser->tweetsCollection() as $tweet)
        {
            $parsedResult[]=$tweet->text();
        }
        return $parsedResult;
    }

    public function writeAnError(string $message, int $code)
    {
        throw new ApiControlledException($message, $code);
    }
}