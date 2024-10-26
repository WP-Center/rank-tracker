<?php

/**
 * Plugin Name: Rank Tracker - SEO Monitoring, Google Rank Tracking, Easy SEO Tracker, Keyword Rank Tracking
 * Plugin URI: https://wpranktracker.com
 * Description: Rank Tracker is the Best Rank Tracker WordPress plugin that tracks SEO Keywords on Google. You can easily monitor your position and ranking on Google
 * Version: 1.1.1
 * Author: WPCenter
 * Author URI: https://wpcenter.io/
 * License: GPLv2 or later
 */

declare(strict_types=1);

namespace WPRankTracker;

defined('ABSPATH') || exit;

if (!class_exists(\WPRankTracker\Plugin::class) && is_readable(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (defined('WP_INSTALLING') && WP_INSTALLING) {
    return;
}

if (defined('WPRT_VERSION')) {
    wp_die(esc_html__('Plugin conflict with Rank Tracker', 'easy-rank-tracker'));
}

define('WPRT_VERSION', '1.1.1');
define('WPRT_PLUGIN_URL', rtrim(plugin_dir_url(__FILE__), '/') . '/');
define('WPRT_PLUGIN_FILE', __FILE__);
define('WPRT_PLUGIN_DIR_PATH', rtrim(plugin_dir_path(__FILE__), '/') . '/');
define('WPRT_PREFIX', 'wprt_');
define('WPRT_API_URL', 'https://wpranktracker.com');
define('WPRT_API_PRODUCT_ID', '12');
define('WPRT_API_LICENSE_ACTIVATION_URL', WPRT_API_URL . '/?edd_action=activate_license&item_id=' . WPRT_API_PRODUCT_ID . '&license=%s&url=' . site_url());
define('WPRT_API_LICENSE_LIMIT_URL', WPRT_API_URL . '/wp-json/wprta/v1/api/check-limit?licenseKey=%s&timeZone=%s');
define('WPRT_API_RANK_URL', WPRT_API_URL . '/wp-json/wprta/v1/api/rank');
define('WPRT_API_REMOVE_LICENSE_URL', WPRT_API_URL . '/wp-json/wprta/v1/api/remove-license?licenseKey=%s');
define('WPRT_INVALID_LICENSE_KEY_MESSAGE', 'The license key is not valid.');
define('WPRT_DAILY_USAGE_LIMIT_EXPIRED', 'Daily Usage Limit Expired!');
define('WPRT_SUPPORT_LINK', 'https://wpranktracker.com/contact-us/');

require_once __DIR__ . '/init.php';

add_action(
    'plugins_loaded',
    static function () {
        // Boostrap the plugin
        if (class_exists(\WPRankTracker\Plugin::class)) {
            \WPRankTracker\Plugin::getInstance();
        }
    }
);
