<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setting
 */
?>
<div class="wprt_keyword">
    <?php require 'header.php'; ?>
    <div class="wprt_settings">
        <form class="wprt_settings_form" action="#" method="POST">
            <div class="wprt_settings_left">
                <div class="wprt_settings_panel">
                    <div class="wprt_settings_panel_heading">
                        <h5><strong><?php esc_html_e( 'License Settings', 'easy-rank-tracker' );?></strong></h5>
                    </div>
                    <div class="wprt_settings_panel_body">
                        <div class="wprt_settings_form_fields_wrapper">
                            <!-- license type & daily remaining request -->
                            <div class="wprt_settings_form_input_col">
                                <div class="wprt_settings_form_input_wrapper">
                                    <label for="license_type">
                                        <?php esc_html_e( 'License Type', 'easy-rank-tracker' );?>
                                    </label>
                                    <input type="text" readonly name="license_type" id="license_type" 
                                        value="<?php esc_attr_e($licenseType, 'easy-rank-tracker') ?>">
                                </div>
                                <div class="wprt_settings_form_input_wrapper">
                                    <label for="daily_request"><?php esc_html_e('Daily Remaining Request', 'easy-rank-tracker') ?></label>
                                    <input type="text" readonly name="daily_request" id="daily_request"
                                        value="<?php esc_attr_e($dailyRequest, 'easy-rank-tracker') ?>">
                                </div>
                            </div>
                            <!-- license key and expiry days -->
                            <?php if ($userTypeHelper->isPremium() === true) : ?>
                                <div class="wprt_settings_form_input_col">
                                    <div class="wprt_settings_form_input_wrapper">
                                        <label for="license_key">
                                            <?php esc_html_e( 'License Key', 'easy-rank-tracker' );?>
                                        </label>
                                        <input type="text" readonly name="license_key" id="license_key"
                                            value="<?php echo esc_attr($licenseKey); ?>">
                                    </div>
                                    <div class="wprt_settings_form_input_wrapper">
                                        <label for="license_expiry_date">
                                            <?php esc_html_e( 'License Expiry Date', 'easy-rank-tracker' );?>
                                        </label>
                                        <input type="text" readonly name="license_expiry_date" id="license_expiry_date"
                                            value="<?php echo esc_html_e($licenseExpiry) ?>">
                                    </div>
                                </div>
                                <div class="wprt_settings_actions">
                                    <button class="wprt_remove_license_submit wprt_button_secondary" type="button">
                                        <?php esc_html_e('Reset License', 'easy-rank-tracker'); ?>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="wprt_settings_panel">
                    <div class="wprt_settings_panel_heading">
                        <h5><strong><?php esc_html_e( 'Report Settings', 'easy-rank-tracker' );?></strong></h5>
                        <p><?php esc_html_e( "Select how often you would like to receive performance reports for your tracked keywords.", 'easy-rank-tracker' );?></p>
                    </div>
                    <div class="wprt_settings_panel_body">
                        <div class="wprt_settings_form_fields_wrapper">
                            <div class="wprt_settings_form_input_col">
                                <div class="wprt_settings_form_input_wrapper">
                                    <label>
                                        <?php esc_html_e( 'Email', 'easy-rank-tracker' );?>
                                    </label>
                                    <input placeholder="<?php echo esc_attr($adminEmail);?>" name="email" id="email"
                                        type="text" class="wprt_settings_mail_input" value="<?php echo esc_attr($notificationEmail); ?>">
                                </div>
                                <div class="wprt_settings_form_input_wrapper">
                                    <label>
                                        <?php esc_html_e( 'Frequency', 'easy-rank-tracker' );?>
                                    </label>
                                    <select name="frequency" id="frequency" required>
                                        <?php
                                            foreach ( $frequencies as $value => $title ):
                                                printf(
                                                    '<option value="%s" %s>%s</option>',
                                                    $value,
                                                    selected( 
                                                        $value,
                                                        ! empty($notificationFrequency) ? $notificationFrequency : 'weekly',
                                                        false ),
                                                    $title
                                                );
                                            endforeach;
                                        ?>
                                    </select>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wprt_settings_right">
                <div class="wprt_settings_panel">
                    <div class="wprt_settings_panel_body">
                        <div class="wprt_settings_form_button_group">
                            <input type="submit" class="wprt_settings_submit wprt_button_primary"
                                value="<?php esc_attr_e( 'Save Settings', 'easy-rank-tracker' );?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>