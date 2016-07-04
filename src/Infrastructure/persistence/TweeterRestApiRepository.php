<?php
namespace App\Infrastructure\Persistence;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Domain\Tweet;
use App\Domain\TweeterRepository;
use App\Domain\TweeterUser;
use App\Domain\TweeterUserId;
use App\Domain\TweetsCollection;
use App\Infrastructure\persistence\CacheClient;

/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 16:00
 */
class TweeterRestApiRepository implements TweeterRepository
{

    public static $_TWEETER_CONSUMER_KEY = 'UAD7v17XGHGbCqcCfbpT48Ryh';
    public static $_TWEETER_CONSUME_SECRET = 'nteO4ec835c0Nma689tRJWtBZXOJYaij63oPKNHf73Chqbu0Kq';
    public static $_TWEETER_ACCESS_TOKEN = '1320990102-Lm9k5m3TfQmiX3xgaJLiPEcn81POVlZ3DWmNX2R';
    public static $_TWEETER_ACCESS_TOKEN_SECRET = '0L148FqLMeKYTQbnoDXGRCjS7JLegqSOYmkS6XV9naAmL';

    /** @var  TwitterOAuth */
    private $connection;

    /** @var  CacheClient */
    private $cacheClient;

    public function __construct(TwitterOAuth $connection, CacheClient $cacheClient = null)
    {
        $this->connection = $connection;
        $this->cacheClient = $cacheClient;
    }

    public function findTweetsByUser(TweeterUserId $userId, $quantity)
    {

        if ($result = $this->tryToSeverResultFromCache($userId->get(), $quantity))
        {
            return $result;
        }

        $resultConnection = $this->verifyConnectionIsUpAndRunning();
        if ($resultConnection === true) {

            $result = $this->connection->get('statuses/user_timeline', array(
                    'screen_name' => $userId->get(),
                    'exclude_replies' => 'true',
                    'include_rts' => 'true',
                    'count' => $quantity
                )
            );
            if ($this->connection->getLastHttpCode() != 200) {
                throw new \Exception($result->errors[0]->message, $this->connection->getLastHttpCode());
            }

            $result = $this->arrangeDomainEntities($userId, $result);

            $this->setResultInCache($userId, $quantity, $result);

            return $result;
        } else {
            throw new \Exception('Connection to Twiter Api can\'t be stablished', $resultConnection);
        }
    }

    private function verifyConnectionIsUpAndRunning()
    {
        $this->connection->get("account/verify_credentials");
        $result = $this->connection->getLastHttpCode();
        if ($result !== 200) {
            return $result;
        }
        return true;

    }

    private function arrangeDomainEntities($user, $result)
    {

        foreach ($result as $tweet) {
            $tweetsResult[] = new Tweet(
                $tweet->text
            );
        }
        $tweetCollection = new TweetsCollection($tweetsResult);
        $tweetUser = new TweeterUser(new TweeterUserId($user), $tweetCollection);
        return $tweetUser;
    }

    private function tryToSeverResultFromCache($userId, $quantity)
    {

        if (($this->cacheClient instanceof CacheClient) && $this->cacheClient->exists('#' . $userId . '_' . $quantity . '#')) {
            return unserialize(base64_decode($this->cacheClient->get('#' . $userId . '_' . $quantity . '#')));
        } else
            return false;
    }

    /**
     * @param TweeterUserId $userId
     * @param $quantity
     * @param $result
     */
    private function setResultInCache(TweeterUserId $userId, $quantity, $result)
    {
        if (($this->cacheClient instanceof CacheClient)) {
            $this->cacheClient->set('#' . $userId->get() . '_' . $quantity . '#', base64_encode(serialize($result)), 60);
        }
    }
}