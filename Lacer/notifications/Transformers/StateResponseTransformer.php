<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/13/15
 * Time: 7:55 AM
 */

namespace App\Vasoft\Transformers;


class StateResponseTransformer extends ResponseTransformer {

    /**
     * Transforms a single item
     * @param array $item the item to transform
     * @return the transformed item
     */
    public function transform(array $item)
    {
        $out = [
            'state_id' => $item['id'],
            'state' => $item['state']
        ];
        $out['country'] = array_key_exists('country', $item) ? $item['country']['country'] : '';
        return $out;
    }
}