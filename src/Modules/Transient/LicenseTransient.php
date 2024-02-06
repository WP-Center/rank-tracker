<?php

namespace WPRankTracker\Modules\Transient;

class LicenseTransient
{
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'licenseDailyCheck']);
    }

    public function licenseDailyCheck()
    {
        $licenseHelper = wprtContainer('LicenseHelper');
        $apiController = wprtContainer('ApiController');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');
        $licenseActivationController = wprtContainer('LicenseActivation');
        $optionsHelper = wprtContainer('OptionsHelper');

        $license = $licenseHelper->getLicense();

        if (($optionsHelper->getTransient('license_check') === false) && ($license !== 'free')) {
            $licenseApiResponse = $apiController->licenseCheck($license);

            if (($licenseApiResponse === false) || ($licenseApiResponse['success'] !== true)) {
                $licenseExpiredController->expiredRemoveLicense();
                $optionsHelper->setTransient('license_check', false, 1);
                return;
            }

            // If the license is still valid, update it.
            $licenseActivationController->licenseKeySaveDatabase($licenseApiResponse);

            $optionsHelper->setTransient('license_check', true, DAY_IN_SECONDS);
        }
    }
}
