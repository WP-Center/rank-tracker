<?php

namespace WPRankTracker\Modules\Ranks;

use DateTime;
use DateTimeZone;
use Illuminate\Container\Container;

class RankController extends Container
{
    /**
     * This method send registerEndpoint function.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerEndpoint']);
    }

    /**
     * @return void
     */
    public function registerEndpoint()
    {
        register_rest_route(
            'wprt/v1/api',
            '/update',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'rankUpdateRest',
                    ],
                ],
            ]
        );
    }

    /**
     * This method allows us to fetch the elements of the object by id.
     *
     * @param \WP_REST_Request $request Contains the data of the submitted value.
     *
     * @return ?void
     * @throws \Exception
     */
    public function rankUpdateRest(\WP_REST_Request $request)
    {
        $keywordController = wprtContainer('GetKeywordsController');
        $responseHelper = wprtContainer('ResponseHelper');

        $request = json_decode($request->get_body());

        $keywordId = sanitize_text_field($request->id);

        $keywordData = null;

        if (!empty($keywordId)) {
            $keywordData = $keywordController->getKeywordById($keywordId);
        }

        if (!empty($keyword) && !empty($country)) {
            $keywordData = $keywordController->getKeywordBy($keyword, $country);
        }

        if (!$keywordData) {
            return $responseHelper->sendJsonError('Invalid request parameters.');
        }

        $this->sendRequestToAPI($keywordData->keyword, $keywordData->country, 'update');
    }

    public function sendRequestToAPI($keyword, $country, $action)
    {
        $apiController = wprtContainer('ApiController');
        $responseHelper = wprtContainer('ResponseHelper');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');
        $keywordController = wprtContainer('GetKeywordsController');
        $optionsHelper = wprtContainer('OptionsHelper');

        $apiResponse = $apiController->getRankFromAPI(
            $keyword,
            $country
        );

        $keywordData = $keywordController->getKeywordBy($keyword, $country);
        $keywordId = $keywordData->id;

        if ($apiResponse['success'] === true) {
            $this->saveRankToDatabase($keywordId, $apiResponse);

            if ($action === 'update') {
                if ($apiResponse['data']['rank'] === '-1') {
                    return $responseHelper->sendJsonError('Not Exist.');
                }

                return $responseHelper->sendJsonSuccess('Keyword position updated succesfully. <br> Check it out!. ', $apiResponse['data']['rank'], 'Keyword Updated Succesfully');
            }

            return $responseHelper->sendJsonSuccess('Keyword added to your list with the correct ranking position. <br> Check it out!. ', $apiResponse['data']['rank'], 'Keyword Added Succesfully');
        }

        if ($apiResponse['data']['message'] === WPRT_INVALID_LICENSE_KEY_MESSAGE) {
            $licenseExpiredController->expiredRemoveLicense();
        }

        if ($apiResponse['data']['message'] === WPRT_DAILY_USAGE_LIMIT_EXPIRED) {
            $optionsHelper->setTransient('api_limit_check', '0', DAY_IN_SECONDS);
        }

        if ($apiResponse['data']['message'] === 'localhost') {
            $responseHelper->sendJsonError('Request cannot be made with localhost!');
        }

        return $responseHelper->sendJsonError($apiResponse['data']['message'] ?? 'Failed to get response from API.');
    }

    /**
     * This method responsible to save rank value to database.
     *
     * @param integer $keywordId Keyword ID.
     * @param array $apiResponse The response from API.
     *
     * @return ?void
     * @throws \Exception
     */
    public function saveRankToDatabase(int $keywordId, array $apiResponse)
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');
        $optionsHelper = wprtContainer('OptionsHelper');

        $newRank = $apiResponse['data']['rank'];

        if ($newRank === null) {
            return;
        }

        $getRankData = $databaseHelper->getRow('ranks', ['keyword_id' => $keywordId], null, '*', 1);

        $getRankData = $getRankData[0] ?? null;

        $unSerializeRankData = $getRankData ? maybe_unserialize($getRankData->ranks) : [];

        $nowDate = $userTimeZoneHelper->getUserDate(null, false);

        $timeZoneUnSerializeRankData = [];
        if ($unSerializeRankData) {
            foreach ($unSerializeRankData as $rankDatumTimeStamp => $rankValue) {
                $timeZoneUnSerializeRankData[$userTimeZoneHelper->getUserDate($rankDatumTimeStamp, false)] = $rankDatumTimeStamp;
            }
        }

        if (isset($timeZoneUnSerializeRankData[$nowDate])) {
            $rankDatumTimeStampKey = $timeZoneUnSerializeRankData[$nowDate];

            $unSerializeRankData[$rankDatumTimeStampKey] = strval($newRank);
        } else {
            $unSerializeRankData[time()] = strval($newRank);
        }

        $newSerializeRankData = maybe_serialize($unSerializeRankData);

        if (!$getRankData) {
            $databaseHelper->addData('ranks', [
                'keyword_id' => $keywordId,
                'ranks' => $newSerializeRankData,
            ]);
        } else {
            $databaseHelper->updateData(
                'ranks',
                ['ranks' => $newSerializeRankData],
                ['id' => $getRankData->id]
            );
        }

        $databaseHelper->updateData(
            'keywords',
            ['last_update_date' => time()],
            ['id' => $keywordId]
        );

        $optionsHelper->setTransient('api_limit_check', strval($apiResponse['data']['remainingApiLimit']), DAY_IN_SECONDS);
    }

    public function getDifferenceRowsFromKeyword(string $keywordId, $dateFrom = 0, $dateTo = 0): array
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');

        if ($dateFrom && $dateTo) {
            $rankRows = $this->getKeywordToRanksColumn($keywordId, $dateFrom, $dateTo, true);
        } elseif (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $rankRows = $this->getKeywordToRanksColumn(
                $keywordId,
                sanitize_text_field(wp_unslash($_GET['dateFrom'] ?? '')), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                sanitize_text_field(wp_unslash($_GET['dateTo'] ?? '')), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                true
            );
        } else {
            $rankRows = $this->getKeywordToRanksColumn($keywordId, 0, 0, true);
        }

        $differenceRankRows = [];
        $previousRank = null;
        $keyCount = 0;
        
        foreach ($rankRows as $dateTime => $currentRankValue) {
            $currentRank = new \stdClass();

            $currentRank->ranks = $currentRankValue;
            $currentRank->created_at = $userTimeZoneHelper->getUserDate($dateTime, false);
            
            if ($keyCount !== 0 && $previousRank === null) {
                $previousRank = $rankRows[array_key_first($rankRows)];
            }

            $notExist = false;
            if ($previousRank === '-1' || $previousRank === 'Not Exist') {
                $previousRank = '0';
                $notExist = true;
            }

            $difference = ($previousRank !== null) ? $currentRankValue - $previousRank : null;
            $arrow = ($difference > 0) ? '--down' : (($difference === 0) ? '--none' : '--up');

            $currentRank->arrow = $notExist ? '--up' : $arrow;
            $currentRank->difference = $notExist ? $currentRankValue : (($difference !== null) ? abs($difference) : '-');

            if ($currentRankValue === '-1') {
                $currentRank->ranks = 'Not Exist';
                $currentRank->arrow = '--none';
                $currentRank->difference = '-';
            }

            $differenceRankRows[] = $currentRank;

            if ($keyCount !== 0) {
                $previousRank = $currentRankValue;
            }

            $keyCount++;
        }
        
        unset($differenceRankRows[0]);

        return $differenceRankRows;
    }

    /**
     * This method find search history and find difference rank value.
     *
     * @param string $keywordId Get value by keywordId number.
     * @param int $dateFrom
     * @param int $dateTo
     *
     * @return array
     */
    public function getRankHistory(string $keywordId, $dateFrom = 0, $dateTo = 0): array
    {
        // @codingStandardsIgnoreStart
        if ($dateFrom && $dateTo) {
            $rankHistory = $this->getKeywordToRanksColumn($keywordId, $dateFrom, $dateTo);
        } elseif (isset($_GET['dateFrom']) && isset($_GET['dateTo'])) { 
            $rankHistory = $this->getKeywordToRanksColumn($keywordId, sanitize_text_field($_GET['dateFrom']), sanitize_text_field($_GET['dateTo']));
        } else {
            $rankHistory = $this->getKeywordToRanksColumn($keywordId);
        }
        
        // @codingStandardsIgnoreEnd
        if (count($rankHistory) > 1) {
            $lastRank = $rankHistory[count($rankHistory) - 1];
            $previousRank = $rankHistory[0];
            $difference = $lastRank - $previousRank;
            if ($difference > 0) {
                $arrow = '--down';
            } elseif ($difference === 0) {
                $arrow = '--none';
            } else {
                $arrow = '--up';
            }

            if ($previousRank === '-1' && $lastRank !== '-1') {
                $difference = $lastRank;
                $arrow = '--up';
            }

            return $lastRank !== '-1' ? [
                'rank' => $lastRank,
                'arrow' => $arrow,
                'difference' => abs($difference),
            ] : [
                'rank' => 'Not Exist',
                'arrow' => '--none',
                'difference' => '-',
            ];
        } elseif (count($rankHistory) === 1) {
            $firstRankValue = $rankHistory[count($rankHistory) - 1];
            $firstRankText = $firstRankValue === '-1' ? 'Not Exist' : $firstRankValue;
        } else {
            $firstRankText = '';
        }
        
        return [
            'rank' => $firstRankText,
            'arrow' => '--none',
            'difference' => '-',
        ];
    }

    /**
     * This method get rank table into rank values and add to array.
     *
     * @param string $keywordId Allows us to list by keyword id value.
     * @param int $dateFrom
     * @param int $dateTo
     *
     * @return array
     */
    public function getKeywordToRanksColumn(string $keywordId, $dateFrom = 0, $dateTo = 0, $keepKeys = false): array
    {
        if (!$dateFrom) {
            $dateFrom = $keepKeys ? (int) gmdate("U", strtotime("-8 days 00:00:00")) : (int) gmdate("U", strtotime("-7 days 00:00:00"));
        } else {
            $dateFrom = $keepKeys ? (int) gmdate("U", strtotime("-1 day", strtotime($dateFrom))) : (int) gmdate("U", strtotime($dateFrom));
        }

        if (!$dateTo) {
            $dateTo = (int) gmdate("U", strtotime("+1 day 00:00:00"));
        } else {
            $dateTo = (int) gmdate("U", strtotime("+1 day", strtotime($dateTo)));
        }
        
        $databaseHelper = wprtContainer('DatabaseHelper');

        $results = $databaseHelper->getRow(
            'ranks',
            ['keyword_id' => $keywordId]
        );

        if (isset($results[0])) {
            $results = maybe_unserialize($results[0]->ranks) ?? [];

            // Remove older and newer data
            $results = array_filter($results, function ($date) use ($dateFrom, $dateTo) {
                return $date >= $dateFrom && $date <= $dateTo;
            }, ARRAY_FILTER_USE_KEY);

            ksort($results);
        }
        
        
        return $keepKeys ? $results : array_values($results);
    }
}
