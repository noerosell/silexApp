<?php
namespace App\Interactors;
use App\Domain\TweeterUserId;


/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 15:53
 */
class GetTweetsFromTweeterUserRequest
{
    private $userId;

    private $quantity;

    /**
     * GetTweetsFromTweeterUserRequest constructor.
     */
    public function __construct($user,$quantity)
    {
        $this->userId=new TweeterUserId($user);
        $this->quantity=$quantity;
    }

    /**
     * @return mixed
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function quantity()
    {
        return $this->quantity;
    }
}