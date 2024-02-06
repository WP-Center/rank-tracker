<?php

namespace WPRankTracker\Modules\Keywords;

class GetKeywordsController
{
    /**
     * Database table name.
     *
     * @var string
     */
    private string $tableName = 'keywords';

    public function getKeywords(): array
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $rankController = wprtContainer('RankController');

        $keywordsAll = $databaseHelper->getRow($this->tableName);

        $mappingKeywords = [];
        foreach ($keywordsAll as $keyword) {
            $ranks = $rankController->getRankHistory($keyword->id);
            $keyword->rank = $ranks['rank'];
            $keyword->arrow = $ranks['arrow'];
            $keyword->difference = $ranks['difference'];

            $mappingKeywords[] = $keyword;
        }

        return $mappingKeywords;
    }

    /**
     * Responsible to get keyword data by keyword id.
     *
     * @param integer $id Keyword ID.
     *
     */
    public function getKeywordById(int $id)
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $keywordData = $databaseHelper->getRow('keywords', ['id' => $id]);

        return $keywordData[0] ?? [];
    }

    /**
     * Responsible to get keyword data by keyword and country.
     *
     * @param string $keywords
     * @param string $country
     */
    public function getKeywordBy(string $keywords, string $country)
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $keywordData = $databaseHelper->getRow('keywords', [
            'keyword' => $keywords,
            'country' => $country,
        ]);

        return $keywordData[0] ?? [];
    }
}
