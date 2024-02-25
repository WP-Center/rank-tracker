<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setting
 */

$userTypeHelper = wprtContainer('UserTypeHelper');
$licenseHelper = wprtContainer('LicenseHelper');

?>
<div class="wprt_keyword">
    <?php require 'header.php'; ?>
    
    <div class="wprt_keyword_list_wrapper">
        <div class="wprt_settings_page">
            <div class="wprt_settings_informations">
                <div class="wprt_settings_labels">
                    <div class="wprt_settings_labels_item">
                        <?php esc_html_e('License Type:', 'easy-rank-tracker'); ?>
                    </div>
                    <div class="wprt_settings_labels_item">
                        <?php esc_html_e('Daily Remaining Request:', 'easy-rank-tracker'); ?>
                    </div>
                    <?php if ($userTypeHelper->isPremium() === true) : ?>
                        <div class="wprt_settings_labels_item">
                            <?php esc_html_e('License Key:', 'easy-rank-tracker'); ?>
                        </div>
                        <div class="wprt_settings_labels_item">
                            <?php esc_html_e('License Remaining Day:', 'easy-rank-tracker'); ?>
                        </div>                
                    <?php endif; ?>
                </div>
                <div class="wprt_settings_values">
                    <div class="wprt_settings_values_item">
                        <?php echo esc_html($userTypeHelper->isFree() === true ? 'Free' : 'Premium') ?>
                    </div>
                    <div class="wprt_settings_values_item">
                        <?php echo esc_html((in_array(get_transient('wprt_api_limit_check'), [false, '']) ? '0' : get_transient('wprt_api_limit_check'))) ?>
                    </div>
    
                    <?php if ($userTypeHelper->isPremium() === true) : ?>
                        <div class="wprt_settings_values_item">
                            <?php
                            $licenseKey = $licenseHelper->getLicense();
                            $licenseKey = substr($licenseKey, 0, 3) . "************************" . substr($licenseKey, (strlen($licenseKey)) - 3, 3);
                            ?>
                            <?php echo esc_html($licenseKey); ?>
                        </div>
                        <div class="wprt_settings_values_item">
                            <?php echo esc_html($licenseHelper->getLicenseRemainingDay()) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="wprt_settings_actions">
                <?php if ($userTypeHelper->isPremium() === true) : ?>
                    <button class="wprt_remove_license_submit wprt_button_secondary">
                        <?php esc_html_e('Reset License', 'easy-rank-tracker'); ?>
                    </button>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>