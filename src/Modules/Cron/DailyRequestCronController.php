<?php

namespace WPRankTracker\Modules\Cron;

class DailyRequestCronController
{
    public function __construct()
    {
        add_action('wprt_rank_daily_api_request', [$this, 'dailyApiRequest']);

        if (!wp_next_scheduled('wprt_rank_daily_api_request')) {
            wp_schedule_event(strtotime('tomorrow ' . gmdate('H:i:s')), 'daily', 'wprt_rank_daily_api_request');
        }
    }

    public function dailyApiRequest(): void
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $rankController = wprtContainer('RankController');
        $apiController = wprtContainer('ApiController');
        $optionsHelper = wprtContainer('OptionsHelper');

        $limit = intval($optionsHelper->getTransient('api_limit_check'));

        $keywords = $databaseHelper->getRow(
            'keywords',
            null,
            ['last_update_date' => 'ASC'],
            '*',
            $limit
        );

        if (!$keywords || count($keywords) < 1) {
            return ;
        }

        /** @var \stdClass $keyword */
        foreach ($keywords as $keyword) {
            $apiResponse = $apiController->getRankFromAPI(
                $keyword->keyword,
                $keyword->country
            );

            if ($apiResponse['success'] === true) {
                $rankController->saveRankToDatabase($keyword->id, $apiResponse);
            }
        }
    }
}