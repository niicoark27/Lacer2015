<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 5/24/15
 * Time: 7:24 AM
 */

namespace App\Vasoft\Contracts;


interface CanSendEmailContract {
    /**
     * Returns the email address to which the mail is being sent
     * @return mixed
     */
    public function getEmailAddress();
}