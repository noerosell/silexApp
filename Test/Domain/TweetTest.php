<?php
namespace Test\Domain;
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 3/7/16
 * Time: 11:48
 */
use App\Domain\Tweet;

class TweetTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testAnExceptionIsThrownWhenTweetIsInvalid()
    {
        $this->expectException(\Exception::class);
        new Tweet('');
    }

    /**
     * @test
     */
    public function testNoExceptionIsThrownWhenTweeIsValid()
    {
        $tweet=new Tweet('Sample');
        $this->assertSame($tweet->text(),'Sample');
    }
}