<?php
namespace App\Domain;
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 15:54
 */
interface TweeterRepository
{
    public function findTweetsByUser(TweeterUserId $userId, $quantity);
}