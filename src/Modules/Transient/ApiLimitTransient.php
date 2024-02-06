<?php

namespace WPRankTracker\Modules\Transient;

class ApiLimitTransient
{
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'apiLimitDailyCheck']);
    }

    public function apiLimitDailyCheck(): void
    {
        $licenseHelper = wprtContainer('LicenseHelper');
        $apiController = wprtContainer('ApiController');
        $optionsHelper = wprtContainer('OptionsHelper');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');

        $license = $licenseHelper->getLicense();

        if (($optionsHelper->getTransient('wprt_api_limit_check') === false)) {
            $apiResponse = $apiController->getLicenseLimit($license);

            if (isset($apiResponse['success']) && $apiResponse['success'] === true) {
                $limit = strval($apiResponse['data']['message']);
                $packageTopLimit = strval($apiResponse['data']['packageLimit']);

                $optionsHelper->setTransient('api_limit_check', $limit, DAY_IN_SECONDS);
                $optionsHelper->setTransient('api_package_limit', $packageTopLimit, DAY_IN_SECONDS);
                return;
            }

            if (isset($apiResponse['data']['message']) && $apiResponse['data']['message'] === WPRT_INVALID_LICENSE_KEY_MESSAGE) {
                $licenseExpiredController->expiredRemoveLicense();
            }
        }
    }
}
