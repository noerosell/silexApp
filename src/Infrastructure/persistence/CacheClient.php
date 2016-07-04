<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 4/7/16
 * Time: 15:18
 */

namespace App\Infrastructure\persistence;


interface CacheClient
{
    /**
     * @param string $key
     * @param mixed  $value
     * @param int    $expiry
     */
    public function set($key, $value, $expiry);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function exists($key);
}
