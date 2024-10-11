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

    /**
     * Rank colors
     *
     * @var array
     */
    private array $rankColors = [
        'up' => '#5AB267',
        'down' => '#E63A57',
        'unchanged' => '#808080',
        'unranked' => '#808080',
        'nodata' => '#808080'
    ];

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

        $mappingKeywords = [];
        $upKeywords = [];
        $downKeywords = [];
        $unchangedKeywords = [];
        $unrankedKeywords = [];

        foreach ($keywordsAll as $keyword) {
            $ranks = $rankController->getRankHistory($keyword->id, gmdate("Y-m-d", strtotime($dateFromFormat)), gmdate('Y-m-d'));

            if ($ranks['arrow'] === '--up') {
                $upKeywords[] = $keyword->id;
                $keyword->status = 'up';
                
            } elseif ($ranks['arrow'] === '--down') {
                $downKeywords[] = $keyword->id;
                $keyword->status = 'down';
            }
            
            if (($ranks['difference'] === 0 || $ranks['difference'] === '-')  && $ranks['rank'] !== '> 100') {
                $unchangedKeywords[] = $keyword->id;
                $keyword->status = 'unchanged';
            }
            
            if ($ranks['rank'] === '> 100'){
                $unrankedKeywords[] = $keyword->id;
                $keyword->status = 'unranked';
            } 
            
            if(empty($ranks['rank'])){
                $keyword->status = 'nodata';
            }

            $keyword->rank = $ranks['rank'];
            $keyword->arrow = $ranks['arrow'];
            $keyword->difference = $ranks['difference'];
            if (isset($keyword->status)) {
                $keyword->color = $this->rankColors[$keyword->status];
            }
            $mappingKeywords[] = $keyword;
        }

        return [
            'allKeywords' => $mappingKeywords,
            'upKeywords' => $upKeywords,
            'downKeywords' => $downKeywords,
            'unchangedKeywords' => $unchangedKeywords,
            'unrankedKeywords' => $unrankedKeywords
        ];
    }

    public function getKeywordStatus($dateFromFormat, $keywordId)
    {
        $rankController = wprtContainer('RankController');

        return $rankController->getRankHistory($keywordId, gmdate("Y-m-d", strtotime($dateFromFormat)), gmdate('Y-m-d'));
    }
}
