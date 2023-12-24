<?php

namespace WPRankTracker\Modules\Admin;

use Illuminate\Container\Container;

class MenuController extends Container
{
    /**
     * This method send to function to add menus and menu options to admin panel
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'registerAdminMenu']);
        add_action('admin_head', [$this, 'hideNotices']);
        add_action('admin_init', [$this, 'handlePremiumRedirect']);
        add_action('admin_init', [$this, 'handleSupportRedirect']);
        add_filter('admin_body_class', [$this, 'hidePremiumMenu']);
        add_filter('plugin_action_links_' . plugin_basename(WPRT_PLUGIN_FILE), [$this, 'addActionLinks']);
    }

    /**
     * @return void
     */
    public function registerAdminMenu(): void
    {
        add_menu_page(
            esc_html__('Rank Tracker', WPRT_TRANSLATE),
            esc_html__('Rank Tracker', WPRT_TRANSLATE),
            'manage_options',
            'wp-rank-tracker',
            [
                $this,
                'renderKeywordsPage',
            ],
            'dashicons-chart-area',
            // Menu splash wp-menu-separator.
            99
        );
        
        $this->registerSubMenu();
    }

    /**
     * Register submenus
     * 
     * @return void
     */
    public function registerSubMenu() 
    {
        add_submenu_page(
            'wp-rank-tracker',
            esc_html__('Keywords', WPRT_TRANSLATE),
            esc_html__('Keywords', WPRT_TRANSLATE),
            'manage_options',
            'wp-rank-tracker',
        );

        add_submenu_page(
            'wp-rank-tracker',
            esc_html__('Settings', WPRT_TRANSLATE),
            esc_html__('Settings', WPRT_TRANSLATE),
            'manage_options',
            'wp-rank-tracker-settings',
            [
                $this,
                'renderSettings',
            ],
        );

        add_submenu_page(
            'wp-rank-tracker',
            esc_html__('Support &#x2197;', WPRT_TRANSLATE),
            esc_html__('Support &#x2197;', WPRT_TRANSLATE),
            'manage_options',
            'wp-rank-tracker-support',
            [
                $this,
                'renderActivation',
            ],
        );

        add_submenu_page(
            'wp-rank-tracker',
            esc_html__('Get Premium', WPRT_TRANSLATE),
            esc_html__('Get Premium', WPRT_TRANSLATE),
            'manage_options',
            'wp-rank-tracker-premium',
            [
                $this,
                'renderActivation',
            ],
        );
    }

    /**
     * @return void
     */
    public function renderKeywordsPage(): void
    {
        $keywordController = wprtContainer('GetKeywordsController');
        $licenseHelper = wprtContainer('LicenseHelper');
        $userTypeHelper = wprtContainer('UserTypeHelper');
        $databaseHelper = wprtContainer('DatabaseHelper');
        $pageHelper = wprtContainer('PageHelper');
        $rankController = wprtContainer('RankController');

        if ($userTypeHelper->isPremium()) {
            $remainingDay = $licenseHelper->getLicenseRemainingDay();
        }
        
        if ($pageHelper->isKeywordDetailPage()) {
            include WPRT_PLUGIN_DIR_PATH . '/templates/ranks-page.php';
            return;
        }

        $keywords = $keywordController->getKeywords();

        include WPRT_PLUGIN_DIR_PATH . '/templates/keywords-page.php';
    }

    /**
     * @return void
     */
    public function renderActivation(): void
    {
        include WPRT_PLUGIN_DIR_PATH . '/templates/activation-page.php';
    }

    /**
     * @return void
     */
    public function renderSettings(): void
    {
        include WPRT_PLUGIN_DIR_PATH . '/templates/settings.php';
    }

    /**
     * This method redirects to the add keyword page if the license is premium
     *
     * @return void
     */
    public function handleSupportRedirect(): void
    {
        $userTypeHelper = wprtContainer('UserTypeHelper');
        
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $page = sanitize_text_field(wp_unslash($_GET['page'] ?? ''));
        $rules = is_admin() && ( $page === 'wp-rank-tracker-support' ) && $userTypeHelper->isPremium();

        if ($rules) {
            $url = WPRT_SUPPORT_LINK;
            wp_redirect($url);
            exit();
        }
    }

    /**
     * This method redirects to the add keyword page if the license is premium
     *
     * @return void
     */
    public function handlePremiumRedirect(): void
    {
        $userTypeHelper = wprtContainer('UserTypeHelper');
        
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $page = sanitize_text_field(wp_unslash($_GET['page'] ?? ''));
        $rules = is_admin() && ( $page === 'wp-rank-tracker-premium' ) && $userTypeHelper->isPremium();

        if ($rules) {
            $url = get_admin_url() . '/admin.php?page=wp-rank-tracker';
            wp_redirect($url);
            exit();
        }
    }

    /**
     * This method is responsible for hiding Get Premium submenu from the sidebar if the user activated the premium.
     *
     * @param string $bodyClass Existing body classes.
     *
     * @return string
     */
    public function hidePremiumMenu(string $bodyClass): string
    {
        $userType = wprtContainer('UserTypeHelper');
        if ($userType->isPremium()) {
            $bodyClass .= ' wprt_premium_activated ';
        }

        return $bodyClass;
    }

    /**
     * This method is responsible to add links for plugins.php
     * 
     * @param $actions
     *
     * @return array
     */
    public function addActionLinks($actions)
    {
        $customActions = [
            'keywords' => sprintf(
                '<a href="%s">%s</a>',
                admin_url('admin.php?page=wp-rank-tracker'),
                __('Keywords', WPRT_TRANSLATE)
            ),
            'support' => sprintf(
                '<a href="%s" target="_blank">%s</a>',
                WPRT_SUPPORT_LINK,
                __('Support', WPRT_TRANSLATE)
            ),
        ];

        return array_merge($customActions, $actions);
    }


    public function hideNotices()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $page = sanitize_text_field(wp_unslash($_GET['page'] ?? ''));
        $rules = is_admin() && ( $page === 'wp-rank-tracker' || $page === 'wp-rank-tracker-support' || $page === 'wp-rank-tracker-settings' || $page === 'wp-rank-tracker-premium');

        if ($rules) {
            remove_all_actions('admin_notices');
        }
    }
}
