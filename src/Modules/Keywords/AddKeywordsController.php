<?php

namespace WPRankTracker\Modules\Keywords;

use Illuminate\Container\Container;

class AddKeywordsController extends Container
{
    /**
     * This method prepare to serve a REST API request.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerEndpoint']);
    }

    /**
     * @return void
     */
    public function registerEndpoint(): void
    {
        register_rest_route(
            'wprt/v1/api',
            '/add',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'addKeywords',
                    ],
                ],
            ]
        );
    }

    /**
     * @param object $request Keywords object.
     *
     * @return ?void
     */
    public function addKeywords(object $request)
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $responseHelper = wprtContainer('ResponseHelper');
        $rankController = wprtContainer('RankController');

        $request = json_decode($request->get_body());
        $keyword = sanitize_text_field($request->keyword);
        $country = sanitize_text_field($request->country);

        if (empty($keyword)) {
            return $responseHelper->sendJsonError('Please add keywords.');
        }

        if ($this->isKeywordExist(['keyword' => $keyword, 'country' => $country])) {
            return $responseHelper->sendJsonError(
                'We couldn’t add the keyword to your list. "%s" keyword already exist. Please try another keyword.',
                $keyword,
                'Error With Adding Keyword'
            );
        }

        $databaseHelper->addData('keywords', [
            'keyword' => $keyword,
            'country' => $country,
            'last_update_date' => time(),
        ]);

        $rankController->sendRequestToAPI($keyword, $country, 'add');
    }

    /**
     * @param array $parameter Keywords array.
     *
     * @return boolean
     */
    public function isKeywordExist(array $parameter): bool
    {
        $databaseHelper = wprtContainer('DatabaseHelper');

        $keywordRows = $databaseHelper->getRow('keywords', $parameter);

        if ($keywordRows && count($keywordRows) > 0) {
            return true;
        }

        return false;
    }
}
