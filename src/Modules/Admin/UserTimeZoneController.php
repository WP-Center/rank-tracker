<?php

namespace WPRankTracker\Modules\Admin;

class UserTimeZoneController
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
            '/user-timezone',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'userTimeZone',
                    ],
                ],
            ]
        );
    }

    /**
     * This method license key send to request function
     *
     * @param \WP_REST_Request $request License key.
     *
     * @return ?void
     */
    public function userTimeZone(\WP_REST_Request $request)
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        $request = json_decode($request->get_body());
        $timeZone = sanitize_text_field($request->timeZone);

        $optionsHelper->setOption('user_timezone', $timeZone);
    }
}
