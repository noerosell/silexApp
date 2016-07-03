<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 3/7/16
 * Time: 16:27
 */

namespace Test\Domain;


use App\Domain\TweeterUser;
use App\Domain\TweeterUserId;
use App\Domain\TweetsCollection;

class TweeterUserTest extends \PHPUnit_Framework_TestCase
{
    private $sampleCollectionTweets;
    private $tweeterUserId;
    private $tweet;

    protected function setUp()
    {
        $this->tweeterUserId=$this->getMockBuilder(TweeterUserId::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tweet=$this->getMockBuilder(Tweet::class)->disableOriginalConstructor()->getMock();

        $this->sampleCollectionTweets=$this->getMockBuilder(TweetsCollection::class)
            ->disableOriginalConstructor()->getMock();

        $this->tweeterUserId->expects($this->once())->method('get')->willReturn('@peitocavernoso');
    }

    /**
     * @test
     */
    public function testAnUserCanBeCreatedWithoutTweetsCollection()
    {

        $tweeterUser=new TweeterUser($this->tweeterUserId, $this->sampleCollectionTweets);
        $this->assertInstanceOf(TweeterUser::class,$tweeterUser);
    }

    /**
     * @test
     */
    public function testAnIteratorIsReturnedNotTheEntireArray()
    {
        $tweeterUser=new TweeterUser($this->tweeterUserId, $this->sampleCollectionTweets);
        $this->sampleCollectionTweets->expects($this->once())->method('getIterator')->willReturn(
            new \ArrayIterator(array())
        );
        $this->assertInstanceOf(\ArrayIterator::class,$tweeterUser->tweetsCollection());
    }
}