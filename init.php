<?php

use Illuminate\Container\Container;

if (!function_exists('wprtContainer')) {
    /**
     * @param $make
     * @param array $parameters
     *
     * @return mixed
     */
    function wprtContainer($make = null, array $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}
