<?php

namespace WPRankTracker\Modules\Admin;

use Illuminate\Container\Container;

class LicenseRemoveController extends Container
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
            return $responseHelper->sendJsonError('License Free !');
        }

        $removeLicenseApiResponse = $apiController->removeLicenseFromDomain($licenseKey);


        if ($removeLicenseApiResponse === false) {
            return $responseHelper->sendJsonError('Failed to connect with API please contact us');
        }

        if ($removeLicenseApiResponse['success'] !== true) {
            return $responseHelper->sendJsonError($removeLicenseApiResponse['data']['message']);
        }

        // Remove Plugin License
        $licenseExpiredController->expiredRemoveLicense();

        return $responseHelper->sendJsonSuccess('License Removed');
    }
}
