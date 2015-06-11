<?php namespace App\Vasoft\Exceptions;

/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/8/15
 * Time: 4:54 PM
 */

class ExistingRecordException extends \RuntimeException{
    protected $message = 'Error! Conflict with existing resource';
}