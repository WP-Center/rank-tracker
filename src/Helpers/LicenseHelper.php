<?php

namespace WPRankTracker\Helpers;

class LicenseHelper
{
    /**
     * @var string
     */
    private string $optionName = 'license_key';

    /**
     * This method get current license key.
     *
     * @return string|null
     */
    public function getLicense(): ?string
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        return $optionsHelper->getOption($this->optionName);
    }

    /**
     * This method set license key in the database.
     *
     * @param string $value License key value.
     *
     * @return boolean
     */
    public function setLicense(string $value): bool
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        return $optionsHelper->setOption($this->optionName, $value);
    }

    /**
     * This method find license remaining time.
     *
     * @return integer
     */
    public function getLicenseRemainingDay(): int
    {
        $optionsHelper = wprtContainer('OptionsHelper');
        $expires = $optionsHelper->getOption('license_expire');
        $currentTime = wp_date('Y-m-d H:i:s', null, wp_timezone());
        $previousTimeStamp = strtotime($currentTime);
        $lastTimeStamp = strtotime($expires);
        $timeDifference = ($lastTimeStamp - $previousTimeStamp);

        return (int) ($timeDifference / (60 * 60 * 24));
    }
}
