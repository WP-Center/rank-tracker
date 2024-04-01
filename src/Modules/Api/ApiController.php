<?php

namespace WPRankTracker\Modules\Api;

class ApiController
{
    /**
     * This method responsible to get rank from API.
     *
     * @param string $keyword Keyword.
     * @param string $country Keyword Location.
     *
     */
    public function getRankFromAPI(string $keyword, string $country)
    {
        $licenseKey = wprtContainer('LicenseHelper');
        $licenseExpiredController = wprtContainer('LicenseExpiredController');
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');

        $licenseKey = $licenseKey->getLicense();

        $apiUrl = WPRT_API_RANK_URL . '?' . http_build_query([
                'licenseKey' => $licenseKey,
                'keyword' => $keyword,
                'country' => $country,
                'timeZone' => $userTimeZoneHelper->getUserTimeZone(),
            ]);

        $arguments = [
            'method' => 'GET',
            'timeout' => 10000,
        ];

        $response = wp_remote_get($apiUrl, $arguments);

        if (is_wp_error($response)) {
            return [
                'success' => false,
                'data' => [
                    'message' => 'Failed to connect with API please contact us.',
                ],
            ];
        }
        
        $response = json_decode(wp_remote_retrieve_body($response), true);
        
        if ($response['success'] !== true && isset($response['data']) && $response['data']['message'] === 'not-valid-license') {
            $licenseExpiredController->expiredRemoveLicense();
            return [
                'success' => false,
                'data' => [
                    'message' => 'Your license key is invalid.',
                ],
            ];
        }

        return $response;
    }

    public function licenseCheck(string $licenseKey)
    {
        $arguments = [
            'method' => 'GET',
            'timeout' => 10000,
        ];

        $apiUrl = sprintf(WPRT_API_LICENSE_ACTIVATION_URL, $licenseKey);
        $response = wp_remote_get($apiUrl, $arguments);

        if (is_wp_error($response)) {
            return false;
        }

        return array_merge(
            json_decode(wp_remote_retrieve_body($response), true),
            ['license_key' => $licenseKey]
        );
    }

    public function getLicenseLimit(string $licenseKey)
    {
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');

        $arguments = [
            'method' => 'GET',
            'timeout' => 10000,
        ];

        $timeZone = $userTimeZoneHelper->getUserTimeZone();

        $apiUrl = sprintf(WPRT_API_LICENSE_LIMIT_URL, $licenseKey, $timeZone);
        $response = wp_remote_get($apiUrl, $arguments);

        if (is_wp_error($response)) {
            return false;
        }

        return array_merge(
            json_decode(wp_remote_retrieve_body($response), true) ?? [],
            ['license_key' => $licenseKey]
        );
    }

    public function removeLicenseFromDomain(string $licenseKey)
    {
        $arguments = [
            'method' => 'GET',
            'timeout' => 10000,
        ];

        $apiUrl = sprintf(WPRT_API_REMOVE_LICENSE_URL, $licenseKey);
        $response = wp_remote_get($apiUrl, $arguments);

        if (is_wp_error($response)) {
            return false;
        }

        return array_merge(
            json_decode(wp_remote_retrieve_body($response), true) ?? [],
            ['license_key' => $licenseKey]
        );
    }
}
