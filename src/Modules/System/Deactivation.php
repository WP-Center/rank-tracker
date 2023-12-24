<?php

namespace WPRankTracker\Modules\System;

use Illuminate\Container\Container;

class Deactivation extends Container
{
    /**
     * This method admin panel or triggered when starting the script.
     */
    public function __construct()
    {
        add_action('admin_init', [$this, 'deactivationHook']);
    }

    /**
     * @return void
     */
    public function deactivationHook()
    {
        do_action('wprt_deactivation');
    }
}
