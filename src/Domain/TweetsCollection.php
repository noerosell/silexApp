<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 17:30
 */

namespace App\Domain;


class TweetsCollection implements \IteratorAggregate
{
    private $tweets=[];

    public function __construct($tweets)
    {
        foreach($tweets as $tweet)
        {
            $this->tweets[]=new Tweet($tweet->text());
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->tweets);
    }
}