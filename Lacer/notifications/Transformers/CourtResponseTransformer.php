<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/13/15
 * Time: 8:12 AM
 */

namespace App\Vasoft\Transformers;


use Illuminate\Support\Facades\Log;

class CourtResponseTransformer extends ResponseTransformer
{

    /**
     * Transforms a single item
     * @param array $item the item to transform
     * @return the transformed item
     */
    public function transform(array $item)
    {
        $out = [
            'court_id' => intval($item['id']),
            'court' => $item['court_name'],
            'court_slug' => $item['court_slug'],
            'par_id' => !empty($item['court_id']) ? intval($item['court_id']) : $item['court_id'],
            'parent_path' => $item['path_string'],
        ];

        // Set the parent court if existing
        if (array_key_exists('parent_court', $item)) {
            $out['parent_court'] = $item['parent_court']['court_name'];
        }

        $this->setLocation($item, $out);
        $this->setCasesCount($item, $out);
        $this->setJudgesCount($item, $out);

        return $out;
    }

    /**
     * Set the location (state and country)
     * @param $item
     * @param $out
     */
    protected function setLocation($item, &$out)
    {
        if (array_key_exists('state', $item)) {
            $out['state'] = is_array($item['state']) ? $item['state']['state'] : $item['state'];

            if (array_key_exists('country', $item['state'])) {
                // The state has a country relation in which the country name is stored as country
                $out['country'] = is_array($item['state']['country']) ?
                    $item['state']['country']['country'] : $item['state']['country'];
            }
        } else {
            $out['state'] = $out['country'] = '';
        }
    }

    /**
     * Set count of cases
     * @param $item
     * @param $out
     */
    protected function setCasesCount($item, &$out)
    {
        if (array_key_exists('cases_count', $item) && is_array($item['cases_count']) && array_key_exists('total', $item['cases_count'])) {
            $out['total_cases'] = intval($item['cases_count']['total']);
        } else {
            $out['total_cases'] = 0;
        }
    }

    /**
     * Set count of judges
     * @param $item
     * @param $out
     */
    protected function setJudgesCount($item, &$out)
    {
        // Belongs to many returns a collection. The first element is the object
//        dd($item);
        if (array_key_exists('judges_count', $item) && is_array($item['judges_count']) && count($item['judges_count']) > 0) {
            $out['total_judges'] = intval($item['judges_count'][0]['total']);
        } else {
            $out['total_judges'] = 0;
        }
    }
}