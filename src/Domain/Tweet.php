<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 17:38
 */

namespace App\Domain;


class Tweet
{
    private $text;

    public function __construct(string $text)
    {
        $this->setText($text);
    }

    private function setText($text)
    {
        if (mb_strlen($text)>0 && mb_strlen($text)<=140)
        {
            $this->text=$text;
        }
        else
        {
            throw new \Exception('This can\'t be a valid twit bro !');
        }
    }

    public function  text()
    {
        return $this->text;
    }
}
