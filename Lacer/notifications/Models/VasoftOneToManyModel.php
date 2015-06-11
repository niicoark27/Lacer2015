<?php namespace App\Vasoft\Models;
use App\Vasoft\Contracts\SyncOneToManyContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/26/15
 * Time: 12:31 AM
 */

abstract class VasoftOneToManyModel extends Model implements SyncOneToManyContract {


    /**
     * Syncs data on a one to many table relation
     * @param int $fk_id the foreign key relation
     * @param array $data the data to sync
     * @return array an array of 2 elements: a boolean (true if either an update occurred - addition, delete or update)
     * and the newly inserted records
     */
    public static function syncOneToManyData($fk_id, array $data) {
        list($to_add, $to_update, $to_delete) = static::getDataToSync($fk_id, $data);

        $were_deleted = $were_updated = $were_added = FALSE;
        if (count($to_delete) > 0) {
            // Run the query on integer values only
            if (static::destroy(array_filter($to_delete, [get_called_class(), 'isDeletable']))) {
                $were_deleted = TRUE;
            }
        }

        if (count($to_update) > 0) {
            $aff_rows = 0;
            foreach ($to_update as $rec) {
                $rec_id = $rec['id'];
                unset($rec['id']);
                $aff_rows += static::where('id', $rec_id)->update($rec);
            }
            $were_updated = $aff_rows > 0;
        }

        $records = [];
        if (count($to_add) > 0) {
            foreach ($to_add as $rec) {
                $records[] = static::create($rec);
            }
            $were_added = count($records) > 0;
        }

        return [$were_added || $were_updated || $were_deleted, $records];
    }

    /**
     * Returns true if the value is a positive integer
     * @param $value
     * @return bool
     */
    protected static function isDeletable($value) {
        return is_numeric($value) && intval($value) > 0;
    }
}