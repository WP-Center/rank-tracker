<?php

namespace WPRankTracker\Modules\System;

class Activation
{
    /**
     * This method admin panel or trigger when start the script.
     */
    public function __construct()
    {
        add_action('admin_init', [$this, 'activationHook']);
    }

    /**
     * @return void
     */
    public function activationHook(): void
    {
        do_action('wprt_activation');
    }
}
