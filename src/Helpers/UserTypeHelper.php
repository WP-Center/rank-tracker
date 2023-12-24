<?php

namespace WPRankTracker\Helpers;

use Illuminate\Container\Container;

class UserTypeHelper extends Container
{
    /**
     * @var string
     */
    private string $optionName = 'user_type';

    /**
     * @return string|null
     */
    public function getUserType(): ?string
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        return $optionsHelper->getOption($this->optionName);
    }

    /**
     * This method responsible to set User Type in Database.
     *
     * @param string $type Free or Premium.
     *
     * @return boolean
     */
    public function setUserType(string $type): bool
    {
        $optionsHelper = wprtContainer('OptionsHelper');

        return $optionsHelper->setOption($this->optionName, $type);
    }

    /**
     * @return boolean
     */
    public function isPremium(): bool
    {
        return $this->getUserType() === 'premium';
    }

    /**
     * @return boolean
     */
    public function isFree(): bool
    {
        return $this->getUserType() === 'free';
    }
}
