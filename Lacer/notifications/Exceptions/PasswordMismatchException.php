<?php namespace App\Vasoft\Exceptions;

class PasswordMismatchException extends \RuntimeException
{
    protected $message = 'The passwords do not match';
}