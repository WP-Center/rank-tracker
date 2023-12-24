<?php

namespace WPRankTracker\Modules\Admin;

use Illuminate\Container\Container;

class UserTypeController extends Container
{
    /**
     * This method plugin activated send function.
     */
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'checkType']);
    }

    /**
     * This method set user type free if it is not set before or license key is free.
     *
     * @return void
     */
    public function checkType(): void
    {
        $userTypeHelper = wprtContainer('UserTypeHelper');
        $licenseHelper = wprtContainer('LicenseHelper');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');

        if (!$userTypeHelper->getUserType() || !$licenseHelper->getLicense()) {
            $licenseExpiredController->expiredRemoveLicense();
        }
    }
}
