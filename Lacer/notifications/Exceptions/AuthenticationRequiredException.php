<?php
namespace App\Vasoft\Exceptions;


class AuthenticationRequiredException extends \RuntimeException {
    protected $message = 'Authentication Required!';

}