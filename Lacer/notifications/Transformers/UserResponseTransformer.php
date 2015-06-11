<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/19/15
 * Time: 3:10 PM
 */

namespace App\Vasoft\Transformers;


class UserResponseTransformer extends ResponseTransformer {

    /**
     * Transforms a single item
     * @param array $user
     * @return mixed
     */
    public function transform(array $user)
    {
        $out =  [
            'user_id' => intval($user['id']),
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'othernames' => $user['othernames'],
            'username' => $user['username'],
            'profile_picture' => $user['profile_photo']
        ];
        if (array_key_exists('emails', $user)) {
            $out['emails'] = $this->transformEmails($user['emails']);
        }
        if (array_key_exists('contact_numbers', $user)) {
            $out['contact_numbers'] = $this->transformContactNumbers($user['contact_numbers']);
        }
        if (array_key_exists('account_type', $user)) {
            $out['account_type'] = [
                'id' => $user['account_type']['id'],
                'user_type' => $user['account_type']['user_type']
            ];
        }
        return $out;
    }

    /**
     * Transform the user's emails
     * @param array $emails
     * @return array
     */
    public function transformEmails(array $emails) {
        return array_map(function($rec) {
            return [
                'id' => intval($rec['id']),
                'email' => $rec['email'],
                'is_verified' => boolval($rec['is_verified']),
                'is_primary' => boolval($rec['is_primary'])
            ];
        }, $emails);
    }

    /**
     * Transform the user's contact numbers
     * @param array $contactNumbers
     * @return array
     */
    public function transformContactNumbers(array $contactNumbers) {
        return array_map(function($rec) {
            return [
                'id' => intval($rec['id']),
                'contact_number' => $rec['contact_number'],
                'is_verified' => boolval($rec['is_verified']),
                'is_primary' => boolval($rec['is_primary'])
            ];
        }, $contactNumbers);
    }
}