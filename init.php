<?php

use WPRankTracker\Plugin;

if (!function_exists('wprtContainer')) {
    /**
     * @param string $make
     * @return mixed
     */
    function wprtContainer(string $make)
    {
        return Plugin::getInstance()->getContainer()->get($make);
    }
}
