<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 5/20/15
 * Time: 6:12 PM
 */

namespace App\Vasoft\Traits;


trait GetsCaseTitle {
    /**
     * @return null|string
     */
    protected function getCaseTitle() {
        $plaintiff = $this->getLitigantNamesForCaseTitle($this->plaintiff);
        $defendant = $this->getLitigantNamesForCaseTitle($this->defendant);

        if (!empty($plaintiff) && !empty($defendant))
            return $plaintiff . ' Vs ' . $defendant;
        return null;
    }

    /**
     * @param $litigant
     * @return null|string
     */
    protected function getLitigantNamesForCaseTitle($litigant) {
        if (count($litigant['names']) == 1)
            return $litigant['names'][0];
        else if (count($litigant['names']) == 2)
            return $litigant['names'][0] . ' and ' . $litigant['names'][1];
        else if (count($litigant['names']) > 2)
            return $litigant['names'][0] . ', ' . $litigant['names'][1] . ' and Co.';
        else
            return NULL;
    }
}