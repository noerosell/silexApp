<?php
namespace App\Infrastructure\Persistence;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Domain\Tweet;
use App\Domain\TweeterRepository;
use App\Domain\TweeterUser;
use App\Domain\TweeterUserId;
use App\Domain\TweetsCollection;

/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 16:00
 */
class TweeterRestApiRepository implements TweeterRepository
{

    public static $_TWEETER_CONSUMER_KEY='UAD7v17XGHGbCqcCfbpT48Ryh';
    public static $_TWEETER_CONSUME_SECRET='nteO4ec835c0Nma689tRJWtBZXOJYaij63oPKNHf73Chqbu0Kq';
    public static $_TWEETER_ACCESS_TOKEN='1320990102-Lm9k5m3TfQmiX3xgaJLiPEcn81POVlZ3DWmNX2R';
    public static $_TWEETER_ACCESS_TOKEN_SECRET='0L148FqLMeKYTQbnoDXGRCjS7JLegqSOYmkS6XV9naAmL';

    /** @var  TwitterOAuth */
    private $connection;

    public function __construct(TwitterOAuth $connection)
    {
        $this->connection=$connection;
    }

    public function findTweetsByUser(TweeterUserId $userId, $quantity)
    {
        $resultConnection=$this->verifyConnectionIsUpAndRunning();
        if ($resultConnection===true) {

            $result = $this->connection->get('statuses/user_timeline', array(
                    'screen_name' => $userId->get(),
                    'exclude_replies' => 'true',
                    'include_rts' => 'true',
                    'count' => $quantity
                )
            );
            if ($this->connection->getLastHttpCode()!=200)
            {
                throw new \Exception($result->errors[0]->message,$this->connection->getLastHttpCode());
            }
            return $this->arrangeDomainEntities($userId, $result);
        }
        else
        {
            throw new \Exception('Connection to Twiter Api can\'t be stablished',$resultConnection);
        }
    }

    private function verifyConnectionIsUpAndRunning()
    {
        $this->connection->get("account/verify_credentials");
        $result=$this->connection->getLastHttpCode();
        if ($result!==200)
        {
            return $result;
        }
        return true;

    }

    private function arrangeDomainEntities($user,$result)
    {

        foreach($result as $tweet)
        {
            $tweetsResult[]=new Tweet(
                $tweet->text
            );
        }
        $tweetCollection=new TweetsCollection($tweetsResult);
        $tweetUser=new TweeterUser(new TweeterUserId($user),$tweetCollection);
        return $tweetUser;
    }
}