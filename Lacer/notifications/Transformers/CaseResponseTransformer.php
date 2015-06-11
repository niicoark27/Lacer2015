<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/20/15
 * Time: 3:28 AM
 */

namespace App\Vasoft\Transformers;


use Illuminate\Support\Facades\Log;

class CaseResponseTransformer extends ResponseTransformer
{

    /**
     * Transforms a single item
     * @param array $item the item to transform
     * @return the transformed item
     */
    public function transform(array $item)
    {
        $out = [
            'case_id' => intval($item['id']),
            'case_title' => $item['case_title'],
            'date_filed' => $item['updated_at'],
            'date_filed_raw' => $item['date_filed_raw'],
            'suit_no' => $item['suit_no']
        ];
        if (array_key_exists('year_filed', $item)) {
            $out['year_filed'] = $item['year_filed'];
        }
        $this->setCaseOutcome($item, $out);
        $this->setCaseType($item, $out);
        $this->setCourt($item, $out);
        $this->setJudges($item, $out);
        $this->setLitigants($item, $out);
        $this->setCorrespondence($item, $out);

        return $out;
    }

    /**
     * Set the case outcome
     * @param $item
     * @param $out
     */
    protected function setCaseOutcome($item, &$out)
    {
        if (array_key_exists('case_outcome', $item) && !empty($item['case_outcome'])) {
            $out['case_outcome'] = array_key_exists('outcome', $item['case_outcome']) ?
                $item['case_outcome']['outcome'] : null;
            return;
        }
        $out['case_outcome'] = null;
    }

    /**
     * Set the case type
     * @param $item
     * @param $out
     */
    protected function setCaseType($item, &$out)
    {
        if (array_key_exists('case_type', $item) && !empty($item['case_type'])) {
            $out['case_type'] = array_key_exists('case_type', $item['case_type']) ?
                $item['case_type']['case_type'] : null;
            return;
        }
        $out['case_type'] = null;
    }

    /**
     * Set the court
     * @param $item
     * @param $out
     */
    protected function setCourt($item, &$out)
    {
        $key = 'court';
        if (!array_key_exists($key, $item) || empty($item[$key])) {
            $out['court'] = null;
            return;
        }

        $court = $item[$key];
        $out['court'] = [
            'court_id' => $court['id'],
            'court_name' => $court['court_name'],
            'court_slug' => $court['court_slug']
        ];
    }

    /**
     * Set the list of presiding judges
     * @param $item
     * @param $out
     */
    protected function setJudges($item, &$out)
    {
        if (array_key_exists('presiding_judges', $item)) {
            if (!is_array($item['presiding_judges'])) {
                $out['judges'] = [];
                return;
            }
            foreach ($item['presiding_judges'] as $rec) {
                $out['judges'][] = [
                    'judge_id' => $rec['id'],
                    'firstname' => $rec['firstname'],
                    'lastname' => $rec['lastname'],
                    'othernames' => $rec['othernames'],
                    'profile_photo' => $rec['profile_photo'],

                ];
            }
        } else {
            $out['judges'] = [];
        }
    }

    /**
     * Set the case litigants
     * @param $item
     * @param $out
     */
    protected function setLitigants($item, &$out)
    {
        if (array_key_exists('litigants', $item) && is_array($item['litigants'])) {
            $lit1 = $item['litigants'][0];
            $lit2 = $item['litigants'][1];

            $this->setLitHelper($lit1, $out);
            $this->setLitHelper($lit2, $out);
        } else {
            $out['plaintiff'] = $out['defendant'] = null;
        }
    }

    /**
     * Helper method for setting litigant information
     * @param $lit
     * @param $out
     */
    protected function setLitHelper($lit, &$out)
    {
        $lit_type = strtolower($lit['litigant_type']['lit_type']);
        $out[$lit_type] = [
            'residential_address' => $lit['residential_address'],
            'commercial_address' => $lit['commercial_address'],
            'litigant_type' => $lit['litigant_type']['lit_type']
        ];

        // Add members
        foreach ($lit['members'] as $rec) {
            $out[$lit_type]['members'][] = [
                'fullname' => $rec['fullname']
            ];
        }

        // Add attorneys
        $out[$lit_type]['attorneys'] = [];
        foreach ($lit['attorneys'] as $rec) {
            $out[$lit_type]['attorneys'][] = [
                'user_id' => $rec['id'],
                'firstname' => $rec['firstname'],
                'lastname' => $rec['lastname'],
                'othernames' => $rec['othernames'],
                'username' => $rec['username'],
                'profile_photo' => $rec['profile_photo'],
                'is_lead_counsel' => boolval($rec['pivot']['is_lead_counsel'])
            ];
        }

        // Add contact numbers
        $out[$lit_type]['contact_numbers'] = [];
        foreach ($lit['contact_numbers'] as $rec) {
            $out[$lit_type]['contact_numbers'][] = [
                'contact_number' => $rec['contact_number']
            ];
        }

        // Add emails
        $out[$lit_type]['emails'] = [];
        foreach ($lit['emails'] as $rec) {
            $out[$lit_type]['emails'][] = [
                'email' => $rec['contact_number']
            ];
        }
    }

    /**
     * Set the correspondences for the case
     * @param $item
     * @param $out
     */
    protected function setCorrespondence($item, &$out)
    {
        if (array_key_exists('correspondences', $item) && is_array($item['correspondences'])) {
            foreach ($item['correspondences'] as $rec) {
                $cor = [
                    'correspondence_id' => intval($rec['id']),
                    'message' => $rec['message'],
                    // For messages not submitted immediately, the updated at field is more relevant
                    'date_added' => $rec['updated_at'],
                    'sender' => $this->getCorrespondenceSender($rec),
                    'attachments' => $this->getCorrespondenceAttachments($rec)
                ];
                // Set additional information if the sender is a lawyer
                if (strtolower($cor['sender']['user_type']) == 'lawyer') {
                    $cor['sender'] = array_merge($cor['sender'], $this->getSenderInfo($cor['sender'], $out));
                }
                $out['correspondences'][] = $cor;
            }
        } else {
            $out['correspondences'] = [];
        }
    }

    /**
     * Get the correspondence sender
     * @param $rec
     * @return array|null
     */
    protected function getCorrespondenceSender($rec)
    {
        if (!array_key_exists('user', $rec) || !is_array($rec['user'])) {
            return NULL;
        }
        $out = [
            'user_id' => $rec['user']['id'],
            'firstname' => $rec['user']['firstname'],
            'lastname' => $rec['user']['lastname'],
            'othernames' => $rec['user']['othernames'],
            'username' => $rec['user']['username'],
            'profile_photo' => $rec['user']['profile_photo']
        ];
        if (array_key_exists('account_type', $rec['user']) && array_key_exists('user_type', $rec['user']['account_type'])) {
            $out['user_type'] = $rec['user']['account_type']['user_type'];
        } else {
            $out['user_type'] = NULL;
        }

        return $out;
    }

    /**
     * Returns information about correspondence sender
     * @param $sender
     * @param $out
     * @return array
     */
    protected function getSenderInfo($sender, $out)
    {
        $to_ret = ['isPlaintiffLawyer' => false, 'isDefenseLawyer' => false];

        // Check if attorney is on the plaintiff or defense side
        foreach ($out['plaintiff']['attorneys'] as $rec) {
            if ($rec['user_id'] == $sender['user_id']) {
                $to_ret['isPlaintiffLawyer'] = true;
                return $to_ret;
            }
        }

        foreach ($out['defendant']['attorneys'] as $rec) {
            if ($rec['user_id'] == $sender['user_id']) {
                $to_ret['isDefenseLawyer'] = true;
                return $to_ret;
            }
        }
        return $to_ret;
    }

    /**
     * Helper method for setting correspondence attachments
     * @param $rec
     * @return array
     */
    protected function getCorrespondenceAttachments($rec)
    {
        if (!array_key_exists('attachments', $rec)) {
            return [];
        }
        $attachments = [];
        foreach ($rec['attachments'] as $rec) {
            Log::info($rec);
            $attachments[] = [
                'file_id' => intval($rec['id']),
                'file_url' => $rec['file_url'],
                'document_title' => $rec['document_title'],
                'date_added' => $rec['created_at']
            ];
        }
        return $attachments;
    }
}