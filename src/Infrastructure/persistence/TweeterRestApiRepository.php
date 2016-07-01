<?php
namespace App\Infrastructure\Persistence;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Domain\Tweet;
use App\Domain\TweeterRepository;
use App\Domain\TweeterUser;
use App\Domain\TweetsCollection;

/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 16:00
 */
class TweeterRestApiRepository implements TweeterRepository
{

    const _TWEETER_CONSUMER_KEY='UAD7v17XGHGbCqcCfbpT48Ryh';
    const _TWEETER_CONSUME_SECRET='nteO4ec835c0Nma689tRJWtBZXOJYaij63oPKNHf73Chqbu0Kq';
    const _TWEETER_ACCESS_TOKEN='1320990102-Lm9k5m3TfQmiX3xgaJLiPEcn81POVlZ3DWmNX2R';
    const _TWEETER_ACCESS_TOKEN_SECRET='0L148FqLMeKYTQbnoDXGRCjS7JLegqSOYmkS6XV9naAmL';

    /** @var  TwitterOAuth */
    private $connection;

    public function findTweetsByUser($user, $quantity)
    {
        $resultConnection=$this->createConnectionToTweeterApi();
        if ($resultConnection===true) {

            $result = $this->connection->get('statuses/user_timeline', array(
                    'screen_name' => $user,
                    'exclude_replies' => 'true',
                    'include_rts' => 'true',
                    'count' => $quantity
                )
            );
            if ($this->connection->getLastHttpCode()!=200)
            {
                throw new \Exception($result->errors[0]->message,$this->connection->getLastHttpCode());
            }
            return $this->arrangeDomainEntities($user, $result);
        }
        else
        {
            throw new \Exception('Connection to Twiter Api can\'t be stablished',$resultConnection);
        }
    }

    private function createConnectionToTweeterApi()
    {
        $this->connection=new TwitterOAuth(
            self::_TWEETER_CONSUMER_KEY,
            self::_TWEETER_CONSUME_SECRET,
            self::_TWEETER_ACCESS_TOKEN,
            self::_TWEETER_ACCESS_TOKEN_SECRET
        );
       return  $this->verifyConnectionIsUpAndRunning();
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
                preg_replace('/^RT /','',$tweet->text,1)
            );
        }
        $tweetCollection=new TweetsCollection($tweetsResult);
        $tweetUser=new TweeterUser($user,$tweetCollection);
        return $tweetUser;
    }
}