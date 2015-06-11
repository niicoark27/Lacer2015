<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/8/15
 * Time: 5:35 PM
 */

namespace App\Vasoft\Exceptions;


class RecordNotFoundException extends \RuntimeException {
    protected $message = 'The resource was not found';
}