<?php

namespace WPRankTracker\Modules\Admin;

class LicenseActivationController
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
            '/activation',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'licenseActivation',
                    ],
	                'permission_callback' => function () {
		                return current_user_can( 'manage_options' );
	                },
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
    public function licenseActivation(\WP_REST_Request $request)
    {
        $activationHelper = wprtContainer('ResponseHelper');

        $request = json_decode($request->get_body());
        $licenseKey = sanitize_text_field($request->license);

        if (is_null($licenseKey)) {
            return $activationHelper->sendJsonError(__('Please enter a license key', 'easy-rank-tracker'));
        }

        $this->sendRequest($licenseKey);
    }

    /**
     * This method license key control and send to API request
     *
     * @param string $licenseKey License key value.
     *
     * @return ?void
     */
    public function sendRequest(string $licenseKey)
    {
        $activationHelper = wprtContainer('ResponseHelper');
        $apiController = wprtContainer('ApiController');

        $licenseApiResponse = $apiController->licenseCheck($licenseKey);
        
        if ($licenseApiResponse === false) {
            return $activationHelper->sendJsonError(__('Failed to connect with API please contact us', 'easy-rank-tracker'), __('License Activation Failed', 'easy-rank-tracker'));
        }

        if (($licenseApiResponse['success'] !== true) && (isset($licenseApiResponse['error']) &&  ($licenseApiResponse['error'] === 'expired'))) {
            return $activationHelper->sendJsonError(__('The license key that you have entered is expired.', 'easy-rank-tracker'), __('License Activation Failed', 'easy-rank-tracker'));
        }
        
        if (($licenseApiResponse['success'] !== true) && isset($licenseApiResponse['data']) && ($licenseApiResponse['data']['message'] === 'localhost')) {
            return $activationHelper->sendJsonError(__('Request cannot be made with localhost!', 'easy-rank-tracker'), __('License Activation Failed', 'easy-rank-tracker'));
        }

        if (($licenseApiResponse['success'] !== true) || ($licenseApiResponse['license'] === 'invalid')) {
            return $activationHelper->sendJsonError(__('The license key that you have entered is invalid.', 'easy-rank-tracker'), __('License Activation Failed', 'easy-rank-tracker'));
        }

        // Save DB
        $this->licenseKeySaveDatabase($licenseApiResponse);

        return $activationHelper->sendJsonSuccess(__('The license key has been successfully added to the database.', 'easy-rank-tracker'), __('License Activation Completed', 'easy-rank-tracker'));
    }

    /**
     * This method saves the license information in the wp_options table.
     *
     * @param array $licenseData License API Response
     *
     * @return ?void
     */
    public function licenseKeySaveDatabase(array $licenseData)
    {
        $userType = wprtContainer('UserTypeHelper');
        $optionsHelper = wprtContainer('OptionsHelper');

        // Save License Options
        $optionsHelper->setOption('license_expire', $licenseData['expires'] ?? '');
        $optionsHelper->setOption('license_payment_id', strval($licenseData['payment_id']) ?? '');
        $optionsHelper->setOption('license_customer_name', $licenseData['customer_name'] ?? '');
        $optionsHelper->setOption('license_customer_email', $licenseData['customer_email'] ?? '');
        $optionsHelper->setOption('license_price_id', $licenseData['price_id'] ?? '');
        $optionsHelper->setOption('license_key', $licenseData['license_key']);

        // Update User Type
        $userType->setUserType('premium');

        $optionsHelper->setTransient('license_check', true, DAY_IN_SECONDS);
        $optionsHelper->deleteTransient('api_limit_check');
    }
}
