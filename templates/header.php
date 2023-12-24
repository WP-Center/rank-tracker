<?php

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
                <?php esc_html_e(sprintf('Active Package: %s', $userTypeHelper->getUserType()), WPRT_TRANSLATE); ?>
            </a>
            <?php if ($pageHelper->isKeywordDetailPage()) : ?>
                <a class="wprt_header_go_back wprt_button_primary" href="<?php menu_page_url('wp-rank-tracker') ?>">
                    <?php $iconHelper->getIcon('go-back.svg') ?>
                    <?php esc_html_e('Go Back', WPRT_TRANSLATE) ?>
                </a>
            <?php else : ?>
                <a class="wprt_header_add_keyword wprt_button_primary" href="javascript:void(0)">
                    <?php esc_html_e('Add Keyword', WPRT_TRANSLATE) ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>