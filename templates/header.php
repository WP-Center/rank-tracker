<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Header
 */

$iconHelper = wprtContainer('IconHelper');
$pageHelper = wprtContainer('PageHelper');
$userTypeHelper = wprtContainer('UserTypeHelper');

?>
<div class="wprt_header">
    <div class="wprt_header_right">
        <div class="wprt_header_logo">
            <?php $iconHelper->getIcon('logo.svg'); ?>
        </div>
    </div>
    <?php if ($pageHelper->isKeywordPage()) : ?>
        <div class="wprt_header_left">
            <a class="wprt_header_package wprt_button_secondary" href="javascript:void(0)">
                <?php
                    printf(
                        /* translators: %s: Package name free or premium */
                        esc_html__( 'Active Package: %s', 'easy-rank-tracker' ),
                        esc_html($userTypeHelper->getUserType())
                    );
                ?>
            </a>
            <?php if ($pageHelper->isKeywordDetailPage()) : ?>
                <a class="wprt_header_go_back wprt_button_primary" href="<?php menu_page_url('wp-rank-tracker') ?>">
                    <?php $iconHelper->getIcon('go-back.svg') ?>
                    <?php esc_html_e('Go Back', 'easy-rank-tracker') ?>
                </a>
            <?php else : ?>
                <a class="wprt_header_add_keyword wprt_button_primary" href="javascript:void(0)">
                    <?php esc_html_e('Add Keyword', 'easy-rank-tracker') ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>