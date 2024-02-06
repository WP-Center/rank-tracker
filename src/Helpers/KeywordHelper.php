<?php

namespace WPRankTracker\Helpers;

class KeywordHelper
{
    /**
     * Database table name.
     *
     * @var string
     */
    private string $tableName = 'keywords';

    public function getKeywordsLastCheck()
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $keywordsAll = $databaseHelper->getRow($this->tableName);
        $keywordsAll = json_decode(wp_json_encode($keywordsAll), true);

        usort($keywordsAll, [$this, 'compareByLastUpdate']);

        return $keywordsAll;
    }

    public function compareByLastUpdate($firstDate, $secondDate)
    {
        return strtotime($secondDate["last_update_date"]) - strtotime($firstDate["last_update_date"]);
    }

    public function getTotalKeywordStasus($dateFromFormat)
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $rankController = wprtContainer('RankController');
        $keywordsAll = $databaseHelper->getRow($this->tableName);

        $upKeywords = [];
        $downKeywords = [];
        foreach ($keywordsAll as $keyword) {
            $ranks = $rankController->getRankHistory($keyword->id, gmdate("Y-m-d", strtotime($dateFromFormat)), gmdate('Y-m-d'));

            if ($ranks['arrow'] === '--up') {
                $upKeywords[] = $keyword->id;
            } elseif ($ranks['arrow'] === '--down') {
                $downKeywords[] = $keyword->id;
            }
        }

        return ['upKeywords' => $upKeywords, 'downKeywords' => $downKeywords];
    }

    public function getKeywordStatus($dateFromFormat, $keywordId)
    {
        $rankController = wprtContainer('RankController');

        return $rankController->getRankHistory($keywordId, gmdate("Y-m-d", strtotime($dateFromFormat)), gmdate('Y-m-d'));
    }
}
