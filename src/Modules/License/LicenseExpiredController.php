<?php

namespace WPRankTracker\Modules\License;

use DateTime;
use DateTimeZone;
use Illuminate\Container\Container;

class LicenseExpiredController extends Container
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'expiredDateCheck']);
    }

    public function expiredDateCheck()
    {
        $optionsHelper = wprtContainer('OptionsHelper');
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');
        $apiController = wprtContainer('ApiController');
        $licenseActivationController = wprtContainer('LicenseActivation');

        $licenseExpireDate = $optionsHelper->getOption('license_expire');
        $licenseKey = $optionsHelper->getOption('license_key');
        
        $rules = $licenseKey && ($licenseKey !== 'free') &&
            (strtotime($licenseExpireDate) < strtotime($userTimeZoneHelper->getUserDate(null)));
        if ($rules) {
            // Send API Server Request
            $licenseApiResponse = $apiController->licenseCheck($licenseKey);

            if (($licenseApiResponse === false) || ($licenseApiResponse['success'] !== true)) {
                $this->expiredRemoveLicense();
                return;
            }

            // If the license is still valid, update it.
            $licenseActivationController->licenseKeySaveDatabase($licenseApiResponse);
        }
    }

    /**
     * This method resets the information in the database when license information is invalid.
     * And makes the user a free user.
     * @return void
     */
    public function expiredRemoveLicense(): void
    {
        $userTypeHelper = wprtContainer('UserTypeHelper');
        $licenseHelper = wprtContainer('LicenseHelper');
        $optionsHelper = wprtContainer('OptionsHelper');

        // Deleted License Options
        $optionsHelper->deleteOption('license_expire');
        $optionsHelper->deleteOption('license_payment_id');
        $optionsHelper->deleteOption('license_customer_name');
        $optionsHelper->deleteOption('license_customer_email');
        $optionsHelper->deleteOption('license_price_id');

        // Update License
        $licenseHelper->setLicense('free');

        // Update User Type
        $userTypeHelper->setUserType('free');

        $optionsHelper->deleteTransient('license_check');
        $optionsHelper->deleteTransient('api_limit_check');
    }
}
