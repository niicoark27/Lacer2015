<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 5/6/15
 * Time: 12:07 PM
 */

namespace App\Vasoft\Transformers;


class DocketResponseTransformer extends ResponseTransformer {

    /**
     * Transforms a single item
     * @param array $item the item to transform
     * @return the transformed item
     */
    public function transform(array $item)
    {
        // Return the case id, suit no, filing date, plaintiffs (names, address, contact numbers, lawyers)
        // defendants (names, address, contact numbers, lawyers), claim statement and attachments
        $out = [
            'case_id' => $item['id'],
            'suit_no' => $item['suit_no'],
            'filing_date' => $item['filing_date']
        ];

    }

    protected function getLitigants($item) {
        foreach ($item['litigants'] as $litigant) {
            $out[strtolower($litigant['litigant_type']['lit_type'])] = [

            ];
        }
    }

    protected function getPlaintiffs($item) {
        foreach ($item['litigants'] as $litigant) {

        }
    }

    protected function getDefendants($item) {

    }
}