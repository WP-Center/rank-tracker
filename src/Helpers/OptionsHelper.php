<?php

namespace WPRankTracker\Helpers;

use Illuminate\Container\Container;

class OptionsHelper extends Container
{
    /**
     * This method get value from wp_options table.
     *
     * @param string $key Database in wp_options title.
     * @param boolean $default Key not found set default.
     *
     * @return false|mixed|void
     */
    public function getOption(string $key, bool $default = false)
    {
        return get_option(WPRT_PREFIX . $key, $default);
    }

    /**
     * This method set value in the wp_options table.
     *
     * @param string $key Database in wp_option title.
     * @param string $value Key not found set value.
     *
     * @return boolean
     */
    public function setOption(string $key, string $value): bool
    {
        return update_option(
            WPRT_PREFIX . $key,
            $value,
        );
    }

    /**
     * This method delete value in the wp_options table.
     *
     * @param string $key Database in wp_option title.
     *
     * @return boolean
     */
    public function deleteOption(string $key): bool
    {
        return delete_option(
            WPRT_PREFIX . $key,
        );
    }

    public function getTransient(string $key, bool $default = false)
    {
        return get_transient(WPRT_PREFIX . $key, $default);
    }

    public function setTransient(string $key, string $value): bool
    {
        return set_transient(
            WPRT_PREFIX . $key,
            $value,
        );
    }

    public function deleteTransient(string $key): bool
    {
        return delete_transient(
            WPRT_PREFIX . $key,
        );
    }
}
