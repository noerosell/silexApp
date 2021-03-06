<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 17:15
 */

namespace App\Domain;


use App\Domain\TweeterUserId;

class TweeterUser
{
    /** @var  TweeterUserId */
    private $userId;

    /** @var  TweetsCollection */
    private $tweets;


    public function __construct(TweeterUserId $userId, TweetsCollection $tweets)
    {
        $this->setUserId($userId);
        $this->tweets=$tweets;
    }

    public function tweetsCollection()
    {
        return $this->tweets->getIterator();
    }

    private function setUserId($userId)
    {
        if (preg_match('/^@[a-zA-Z0-9_]+/',$userId->get())===1)
        {
            $this->userId=$userId;
        }
        else
            throw new \Exception('This can\'t be a twiter user_name bro !',400);
    }
}