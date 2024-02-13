<?php

namespace WPRankTracker\Modules\Transient;

class TransientCheckController
{
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'transientDateCheck']);
    }

    public function transientDateCheck(): void
    {
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');

        $transientNames = [
            WPRT_PREFIX . 'api_limit_check',
            WPRT_PREFIX . 'license_check',
        ];

        foreach ($transientNames as $transient) {
            $timeoutOption = get_option('_transient_timeout_' . $transient);

            if (!$timeoutOption) {
                return;
            }

            $timeoutDate = wp_date('Y-m-d', $timeoutOption, wp_timezone());

            $nowDate = $userTimeZoneHelper->getUserDate(null, false);

            if ($nowDate >= $timeoutDate) {
                delete_transient($transient);
            }
        }
    }
}
