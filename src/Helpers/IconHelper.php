<?php

namespace WPRankTracker\Helpers;

use Illuminate\Container\Container;

class IconHelper extends Container
{
    /**
     * This method renders an icon from the images folder.
     *
     * @param string $icon This should be icon name and extension.
     *
     * @return void
     */
    public function getIcon(string $icon): void
    {
        include WPRT_PLUGIN_DIR_PATH . 'build/images/icons/' . $icon;
    }

    public function getIconUrl(string $icon): string
    {
        return WPRT_PLUGIN_URL . 'build/images/icons/' . $icon;
    }
    
    public function getCountryListWithFlags() 
    {
        return [
            'AF' => '🇦🇫', 'AO' => '🇦🇴', 'AL' => '🇦🇱', 'AD' => '🇦🇩', 'AE' => '🇦🇪', 'AR' => '🇦🇷', 'AM' => '🇦🇲', 'AG' => '🇦🇬', 'AU' => '🇦🇺', 'AT' => '🇦🇹', 'AZ' => '🇦🇿', 'BI' => '🇧🇮', 'BE' => '🇧🇪', 'BJ' => '🇧🇯', 'BF' => '🇧🇫', 'BD' => '🇧🇩', 'BG' => '🇧🇬', 'BH' => '🇧🇭', 'BS' => '🇧🇸', 'BA' => '🇧🇦', 'BY' => '🇧🇾', 'BZ' => '🇧🇿', 'BO' => '🇧🇴', 'BR' => '🇧🇷', 'BB' => '🇧🇧', 'BN' => '🇧🇳', 'BT' => '🇧🇹', 'BW' => '🇧🇼', 'CF' => '🇨🇫', 'CA' => '🇨🇦', 'CH' => '🇨🇭', 'CL' => '🇨🇱', 'CN' => '🇨🇳', 'CI' => '🇨🇮', 'CM' => '🇨🇲', 'CD' => '🇨🇩', 'CG' => '🇨🇬', 'CO' => '🇨🇴', 'KM' => '🇰🇲', 'CV' => '🇨🇻', 'CR' => '🇨🇷', 'CU' => '🇨🇺', 'CY' => '🇨🇾', 'CZ' => '🇨🇿', 'DE' => '🇩🇪', 'DJ' => '🇩🇯', 'DM' => '🇩🇲', 'DK' => '🇩🇰', 'DO' => '🇩🇴', 'DZ' => '🇩🇿', 'EC' => '🇪🇨', 'EG' => '🇪🇬', 'ER' => '🇪🇷', 'ES' => '🇪🇸', 'EE' => '🇪🇪', 'ET' => '🇪🇹', 'FI' => '🇫🇮', 'FJ' => '🇫🇯', 'FR' => '🇫🇷', 'FM' => '🇫🇲', 'GA' => '🇬🇦', 'GB' => '🇬🇧', 'GE' => '🇬🇪', 'GH' => '🇬🇭', 'GN' => '🇬🇳', 'GM' => '🇬🇲', 'GW' => '🇬🇼', 'GQ' => '🇬🇶', 'GR' => '🇬🇷', 'GD' => '🇬🇩', 'GT' => '🇬🇹', 'GY' => '🇬🇾', 'HN' => '🇭🇳', 'HR' => '🇭🇷', 'HT' => '🇭🇹', 'HU' => '🇭🇺', 'ID' => '🇮🇩', 'IN' => '🇮🇳', 'IE' => '🇮🇪', 'IR' => '🇮🇷', 'IQ' => '🇮🇶', 'IS' => '🇮🇸', 'IL' => '🇮🇱', 'IT' => '🇮🇹', 'JM' => '🇯🇲', 'JO' => '🇯🇴', 'JP' => '🇯🇵', 'KZ' => '🇰🇿', 'KE' => '🇰🇪', 'KG' => '🇰🇬', 'KH' => '🇰🇭', 'KI' => '🇰🇮', 'KN' => '🇰🇳', 'KR' => '🇰🇷', 'KW' => '🇰🇼', 'LA' => '🇱🇦', 'LB' => '🇱🇧', 'LR' => '🇱🇷', 'LY' => '🇱🇾', 'LC' => '🇱🇨', 'LI' => '🇱🇮', 'LK' => '🇱🇰', 'LS' => '🇱🇸', 'LT' => '🇱🇹', 'LU' => '🇱🇺', 'LV' => '🇱🇻', 'MA' => '🇲🇦', 'MC' => '🇲🇨', 'MD' => '🇲🇩', 'MG' => '🇲🇬', 'MV' => '🇲🇻', 'MX' => '🇲🇽', 'MH' => '🇲🇭', 'MK' => '🇲🇰', 'ML' => '🇲🇱', 'MT' => '🇲🇹', 'MM' => '🇲🇲', 'ME' => '🇲🇪', 'MN' => '🇲🇳', 'MZ' => '🇲🇿', 'MR' => '🇲🇷', 'MU' => '🇲🇺', 'MW' => '🇲🇼', 'MY' => '🇲🇾', 'NA' => '🇳🇦', 'NE' => '🇳🇪', 'NG' => '🇳🇬', 'NI' => '🇳🇮', 'NL' => '🇳🇱', 'NO' => '🇳🇴', 'NP' => '🇳🇵', 'NR' => '🇳🇷', 'NZ' => '🇳🇿', 'OM' => '🇴🇲', 'PK' => '🇵🇰', 'PA' => '🇵🇦', 'PE' => '🇵🇪', 'PH' => '🇵🇭', 'PW' => '🇵🇼', 'PG' => '🇵🇬', 'PL' => '🇵🇱', 'KP' => '🇰🇵', 'PT' => '🇵🇹', 'PY' => '🇵🇾', 'QA' => '🇶🇦', 'RO' => '🇷🇴', 'RU' => '🇷🇺', 'RW' => '🇷🇼', 'SA' => '🇸🇦', 'SD' => '🇸🇩', 'SN' => '🇸🇳', 'SG' => '🇸🇬', 'SB' => '🇸🇧', 'SL' => '🇸🇱', 'SV' => '🇸🇻', 'SM' => '🇸🇲', 'SO' => '🇸🇴', 'RS' => '🇷🇸', 'SS' => '🇸🇸', 'ST' => '🇸🇹', 'SR' => '🇸🇷', 'SK' => '🇸🇰', 'SI' => '🇸🇮', 'SE' => '🇸🇪', 'SZ' => '🇸🇿', 'SC' => '🇸🇨', 'SY' => '🇸🇾', 'TD' => '🇹🇩', 'TG' => '🇹🇬', 'TH' => '🇹🇭', 'TJ' => '🇹🇯', 'TM' => '🇹🇲', 'TL' => '🇹🇱', 'TO' => '🇹🇴', 'TT' => '🇹🇹', 'TN' => '🇹🇳', 'TR' => '🇹🇷', 'TV' => '🇹🇻', 'TZ' => '🇹🇿', 'UG' => '🇺🇬', 'UA' => '🇺🇦', 'UY' => '🇺🇾', 'US' => '🇺🇸', 'UZ' => '🇺🇿', 'VA' => '🇻🇦', 'VC' => '🇻🇨', 'VE' => '🇻🇪', 'VN' => '🇻🇳', 'VU' => '🇻🇺', 'WS' => '🇼🇸', 'YE' => '🇾🇪', 'ZA' => '🇿🇦', 'ZM' => '🇿🇲', 'ZW' => '🇿🇼',
        ];
    }

    public function getFlagByCountry($country = '')
    {
        if ($country) {
            $countryList = $this->getCountryListWithFlags();
            foreach ($countryList as $countryCode => $flag) {
                if ($countryCode === $country) {
                    return $flag;
                }
            }
        }

        return $country;
    }
}
