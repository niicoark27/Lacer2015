<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/17/15
 * Time: 7:38 AM
 */

namespace App\Vasoft\Contracts;


interface CanEmailTokenContract {
    /**
     * Returns the token being sent
     * @return mixed
     */
    public function getToken();
}