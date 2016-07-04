<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 4/7/16
 * Time: 15:19
 */

namespace App\Infrastructure\persistence;


use Predis\Client;

class PredisCacheClient implements CacheClient
{
    /** @var RedisClient  */
    private $redisClient;

    /**
     * @param RedisClient $redisClient
     */
    public function __construct(Client $redisClient)
    {
        $this->redisClient = $redisClient;

    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $expiry
     */
    public function set($key, $value, $expiry)
    {
        if ($this->redisClient->isConnected()) {
            $this->redisClient->set($key, $value, 'EX', $expiry);
        }
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($this->redisClient->isConnected()) {
            $value = $this->redisClient->get($key);

            return $value ? $value : null;
        }
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function exists($key)
    {
        if ($this->redisClient->isConnected()) {
            return $this->redisClient->exists($key);
        }
    }
}
