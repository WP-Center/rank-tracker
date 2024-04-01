<?php

namespace WPRankTracker\Helpers;

use DateTime;
use DateTimeZone;

class UserTimeZoneHelper
{
    /**
     * @var string
     */
    private string $optionName = 'user_timezone';

    /**
     * @return string
     */
    public function getUserTimeZone(): string
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        $timeZone = $optionsHelper->getOption($this->optionName);

        if (empty($timeZone) || $timeZone === '00:00') {
            return wp_timezone_string();
        }

        return $timeZone;
    }

    /**
     * @param string $timeZone
     * @return boolean
     */
    public function setUserTimeZone(string $timeZone): bool
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        return $optionsHelper->setOption($this->optionName, $timeZone);
    }

    public function getUserDate($timestamp = null, bool $isFull = true, $dateFormat = 'd M Y H:i:s'): ?string
    {
        $timeZone = $this->getUserTimeZone();

        if (empty($timestamp)) {
            $timestamp = time();
        }

        $dateTimeObj = new DateTime();
        $dateTimeObj->setTimezone(new DateTimeZone($timeZone));
        $dateTimeObj->setTimestamp(intval($timestamp));

        if (!$isFull) {
            return $dateTimeObj->format('Y-m-d');
        }

        return $dateTimeObj->format($dateFormat);
    }
}
