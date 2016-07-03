<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 3/7/16
 * Time: 16:17
 */

namespace Test\Domain;


use App\Domain\Tweet;
use App\Domain\TweetsCollection;

class TweetCollectionTest extends \PHPUnit_Framework_TestCase
{
    private $sampleCollectionTweets;
    private $tweet;

    protected function setUp()
    {
        $this->tweet=$this->getMockBuilder(Tweet::class)->disableOriginalConstructor()->getMock();
        $this->sampleCollectionTweets=array_fill(0,10,$this->tweet);
    }
    /**
     * @test
     */
    public function testAllTweetsAreInCollection()
    {
        $counter=0;
        $this->tweet->expects($this->any())->method('text')->willReturn('sample');
        $tweetsCollection=new TweetsCollection(($this->sampleCollectionTweets));
        foreach($tweetsCollection->getIterator() as $tweet)
        {
            $counter++;
            $this->assertInstanceOf(Tweet::class,$tweet);
        }

        $this->assertEquals(count($this->sampleCollectionTweets),$counter);
    }
}