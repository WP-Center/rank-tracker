<?php

namespace WPRankTracker\Modules\Admin;

class FrontendLocalizeController{
    /**
     * Hooks function to localize script
     */
    function __construct()
    {
        add_filter('wprt_localize_script', [$this, 'addLocalizeStrings']);   
    }

    /**
     * Add localize strings
     *
     * @param array $vars
     * @return array
     */
    public function addLocalizeStrings( array $vars) : array
    {
        $vars['locales'] = [
            'processing' => __('Processing...', 'easy-rank-tracker'),
        ];

        return $vars;
    }
}