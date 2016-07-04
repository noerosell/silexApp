<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 4/7/16
 * Time: 18:13
 */

namespace App\Api;


class ApiControlledException extends \Exception
{
    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

}