<?php
namespace App\Domain;
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 15:59
 */
interface TweetsPresenter
{
    public function write(TweeterUser $tweeterUser);
}