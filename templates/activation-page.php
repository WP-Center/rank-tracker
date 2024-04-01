<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Activation Page
 */

$iconHelper = wprtContainer('IconHelper');
?>
<div class="wprt_keyword">
    <?php require 'header.php'; ?>
    
    <div class="wprt_activation">
        <div class="wprt_activation_license">
            <div class="wprt_activation_license_icon">
                <img src="<?php echo esc_url($iconHelper->getIconUrl('license-page-icon.png')) ?>">
            </div>
            <div class="wprt_activation_license_title">
                <?php echo wp_kses(__('Enter your license key to activate <br> Rank Tracker Premium', 'easy-rank-tracker'), ['br' => []]); ?>
            </div>

            <form class="wprt_activation_license_form" method="post">
                <input required placeholder="<?php esc_attr_e('Your license key', 'easy-rank-tracker'); ?>" name="activationKey"
                    type="text" class="wprt_activation_license_input">
                <input type="submit" class="wprt_activation_license_submit wprt_button_primary"
                    value="<?php esc_attr_e('Activate License', 'easy-rank-tracker'); ?>">
            </form>

            <div class="wprt_activation_license_support">
                <?php
                /* translators: %1\$s: Website link */
                /* translators: %2\$s: Support link */
                echo wp_kses(sprintf(__("If you don’t know your license key, you can get from %1\$s or contact with %2\$s.", 'easy-rank-tracker'), '<a href="https://wpranktracker.com" target="_blank">here</a>', '<a href="https://wpranktracker.com" target="_blank">support</a>'), ['a' => ['href' => [], 'target' => []]]); 
                
                ?>
            </div>
            
            <div class="wprt_activation_license_error">
                <div class="wprt_activation_license_error_title"></div>
                <div class="wprt_activation_license_error_description"></div>
            </div>
            
            <div class="wprt_activation_package_wrapper">
                <div class="wprt_activation_package_icon">
                    <img src="<?php echo esc_url($iconHelper->getIconUrl('license-page-packages-icon.png')) ?>">
                </div>
                <div class="wprt_activation_package_title">
                    <?php esc_html_e('Simple transparent pricing', 'easy-rank-tracker'); ?>
                </div>
                <div class="wprt_activation_package_description">
                    <?php esc_html_e('Choose the right pricing plan for your business', 'easy-rank-tracker');?>
                </div>
                <div class="wprt_activation_package_list">
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_title">Basic</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>6.99<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Track up to <strong>10</strong> keywords daily</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Unlimited website usage</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Save reports in PDF or CSV formats</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Detailed Ranking History</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Customizable reporting options</div>
                        </div>
                        <a href="https://wpranktracker.com/pricing/" target="_blank" class="wprt_button_secondary wprt_activation_package_button">Choose Plan</a>
                    </div>
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_badge">Most Popular</div>
                        <div class="wprt_activation_package_item_title">Standard</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>29.99<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Track up to <strong>50</strong> keywords daily</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Unlimited website usage</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Save reports in PDF or CSV formats</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Detailed Ranking History</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Customizable reporting options</div>
                        </div>
                        <a href="https://wpranktracker.com/pricing/" target="_blank" class="wprt_button_primary wprt_activation_package_button">Choose Plan</a>
                    </div>
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_title">Basic</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>119.99<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Track up to <strong>200</strong> keywords daily</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Unlimited website usage</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Save reports in PDF or CSV formats</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Detailed Ranking History</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Customizable reporting options</div>
                        </div>
                        <a href="https://wpranktracker.com/pricing/" target="_blank" class="wprt_button_secondary wprt_activation_package_button">Choose Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>