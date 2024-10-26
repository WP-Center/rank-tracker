<?php

namespace WPRankTracker\Modules\Keywords;

class DeleteKeywordsController
{
    /**
     * Database table name.
     *
     * @var string
     */
    private string $keywordTable = 'keywords';

    /**
     * Database table name.
     *
     * @var string
     */
    private string $rankTable = 'ranks';

    /**
     *  This method REST API triggers when preparing to serve the request.
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
            '/delete',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'deleteKeywords',
                    ],
	                'permission_callback' => function () {
		                return current_user_can( 'manage_options' );
	                },
                ],
            ]
        );
    }

    /**
     * This method keyword deleted to database.
     *
     * @param object $request Delete keyword request.
     *
     * @return ?void
     */
    public function deleteKeywords(object $request)
    {
        global $wpdb;
        $databaseHelper = wprtContainer('DatabaseHelper');
        $responseHelper = wprtContainer('ResponseHelper');

        $request = json_decode($request->get_body());
        $keywordId = sanitize_text_field($request->id);

        $databaseHelper->deleteData($this->keywordTable, ['id' => $keywordId]);
        $databaseHelper->deleteData($this->rankTable, ['keyword_id' => $keywordId]);

        if ($wpdb->last_error) {
            return $responseHelper->sendJsonError(__('Something went wrong during the process.', 'easy-rank-tracker'));
        }

        return $responseHelper->sendJsonSuccess(__('Keyword and Rank successfully deleted.', 'easy-rank-tracker'));
    }
}
