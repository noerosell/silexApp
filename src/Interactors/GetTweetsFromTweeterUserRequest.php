<?php
namespace App\Interactors;
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 15:53
 */
class GetTweetsFromTweeterUserRequest
{
    private $user;

    private $quantity;

    /**
     * GetTweetsFromTweeterUserRequest constructor.
     */
    public function __construct($user,$quantity)
    {
        $this->user=$user;
        $this->quantity=$quantity;
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function quantity()
    {
        return $this->quantity;
    }
}