<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/19/15
 * Time: 3:08 PM
 */

namespace App\Vasoft\Transformers;


abstract class ResponseTransformer {

    /**
     * Transforms a collection of items
     * @param array $collection
     * @return array
     */
    public function transformCollection(array $collection) {
        return array_map([$this, 'transform'], $collection);
    }

    /**
     * Transforms a single item
     * @param array $item the item to transform
     * @return the transformed item
     */
    public abstract function transform(array $item);
}