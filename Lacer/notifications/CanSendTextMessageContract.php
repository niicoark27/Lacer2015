<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/27/15
 * Time: 4:07 PM
 */

namespace App\Vasoft\Contracts;


interface CanSendTextMessageContract {
    static function sendTextMessage(array $recipients, $message);
}