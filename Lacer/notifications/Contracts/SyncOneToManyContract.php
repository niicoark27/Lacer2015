<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/13/15
 * Time: 7:47 AM
 */

namespace App\Vasoft\Contracts;


interface SyncOneToManyContract {
    /**
     * Get the one to many data to sync
     * @param int $fk_id the foreign key id
     * @param array $data the data to sync
     * @return mixed
     */
    static public function getDataToSync($fk_id, array $data);
}