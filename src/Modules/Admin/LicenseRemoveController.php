<?php

namespace WPRankTracker\Modules\Admin;

class LicenseRemoveController
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
            '/remove-license',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'removeLicense',
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
    public function removeLicense(\WP_REST_Request $request)
    {
        $responseHelper = wprtContainer('ResponseHelper');
        $apiController = wprtContainer('ApiController');
        $licenseHelper = wprtContainer('LicenseHelper');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');

        $licenseKey = $licenseHelper->getLicense();

        if ($licenseKey === 'free') {
            return $responseHelper->sendJsonError(__('License is free!', 'easy-rank-tracker'));
        }

        $removeLicenseApiResponse = $apiController->removeLicenseFromDomain($licenseKey);


        if ($removeLicenseApiResponse === false) {
            return $responseHelper->sendJsonError(__('Failed to connect with API please contact us', 'easy-rank-tracker'));
        }

        if ($removeLicenseApiResponse['success'] !== true) {
            return $responseHelper->sendJsonError(esc_html( $removeLicenseApiResponse['data']['message']));
        }

        // Remove Plugin License
        $licenseExpiredController->expiredRemoveLicense();

        return $responseHelper->sendJsonSuccess(__('License Removed', 'easy-rank-tracker'));
    }
}
