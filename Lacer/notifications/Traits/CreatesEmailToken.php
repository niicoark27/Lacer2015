<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/9/15
 * Time: 12:05 PM
 */

namespace App\Vasoft\Traits;


trait CreatesEmailToken {
    /**
     * Creates a new token
     * @param $data
     * @param $hashKey
     * @return string
     */
    public function createToken($data, $hashKey) {
        return hash_hmac("sha256", uniqid($data), $hashKey);
    }
}