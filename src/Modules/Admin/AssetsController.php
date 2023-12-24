<?php

namespace WPRankTracker\Modules\Admin;

use Illuminate\Container\Container;

class AssetsController extends Container
{
    /**
     * This method used to retrieve the patient list.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueStyles']);
    }

    /**
     * @return void
     */
    public function enqueueScripts(): void
    {
        $userTypeHelper = wprtContainer('UserTypeHelper');

        wp_enqueue_script(
            'wprt_script',
            WPRT_PLUGIN_URL . '/dist/js/app.min.js',
            ['jquery'],
            filemtime(WPRT_PLUGIN_DIR_PATH . '/dist/js/app.min.js')
        );
        wp_localize_script(
            'wprt_script',
            'wprtObject',
            [
                'wprtRestUrl' => home_url('/wp-json/wprt/v1/api/'),
                'wprtInvalidTokenMessage' => WPRT_INVALID_LICENSE_KEY_MESSAGE,
                'wprtDailyUsageLimitExpired' => WPRT_DAILY_USAGE_LIMIT_EXPIRED,
                'wprtUserFree' => strval($userTypeHelper->isFree()),
            ]
        );
    }

    /**
     * @return void
     */
    public function enqueueStyles(): void
    {
        wp_enqueue_style(
            'wprt_style',
            WPRT_PLUGIN_URL . '/dist/css/app.min.css',
            [],
            filemtime(WPRT_PLUGIN_DIR_PATH . '/dist/css/app.min.css')
        );
    }
}
