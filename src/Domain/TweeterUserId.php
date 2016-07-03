<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 3/7/16
 * Time: 16:35
 */

namespace App\Domain;


class TweeterUserId
{
    private $id;

    public function __construct(string $tweeterUserId)
    {
        $this->setId($tweeterUserId);
    }

    private function setId($value)
    {
        $this->id=$value;
    }

    public function get()
    {
        return $this->id;
    }


    public function __toString()
    {
        return (string) $this->get();
    }
}