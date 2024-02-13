<?php

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
                <?php echo wp_kses(__('Enter your license key to activate <br> Rank Tracker Premium', 'wp-rank-tracker'), ['br' => []]); ?>
            </div>

            <form class="wprt_activation_license_form" method="post">
                <input required placeholder="<?php esc_attr_e('Your license key', 'wp-rank-tracker'); ?>" name="activationKey"
                    type="text" class="wprt_activation_license_input">
                <input type="submit" class="wprt_activation_license_submit wprt_button_primary"
                    value="<?php esc_attr_e('Activate License', 'wp-rank-tracker'); ?>">
            </form>

            <div class="wprt_activation_license_support">
                <?php echo wp_kses(sprintf(__("If you don’t know your license key, you can get from %1\$s or contact with %2\$s.", 'wp-rank-tracker'), '<a href="https://wpranktracker.com" target="_blank">here</a>', '<a href="https://wpranktracker.com" target="_blank">support</a>'), ['a' => ['href' => [], 'target' => []]]); ?>
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
                    <?php esc_html_e('Simple transparent pricing', 'wp-rank-tracker'); ?>
                </div>
                <div class="wprt_activation_package_description">
                    <?php esc_html_e('Choose the right pricing plan for your business', 'wp-rank-tracker');?>
                </div>
                <div class="wprt_activation_package_list">
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_title">Basic</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>9<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Track up to 5 keywords daily</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Weekly ranking updates</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Email support service</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> User-friendly interface</div>
                        </div>
                        <a href="https://wpranktracker.com/" target="_blank" class="wprt_button_secondary wprt_activation_package_button">Choose Plan</a>
                    </div>
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_badge">Most Popular</div>
                        <div class="wprt_activation_package_item_title">Standard</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>12<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Track up to 20 keywords daily</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Daily ranking updates</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Live chat support</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Customizable reporting options</div>
                        </div>
                        <a href="https://wpranktracker.com/" target="_blank" class="wprt_button_primary wprt_activation_package_button">Choose Plan</a>
                    </div>
                    <div class="wprt_activation_package_item">
                        <div class="wprt_activation_package_item_title">Basic</div>
                        <div class="wprt_activation_package_item_price"><sup class="currency-symbol">$</sup>28<span>/month</span></div>
                        <div class="wprt_activation_package_item_feature">
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Unlimited keyword tracking</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Real-time ranking updates</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> Dedicated customer service</div>
                            <div class="wprt_activation_package_item_feature_item"><img src="<?php echo esc_url($iconHelper->getIconUrl('list-icon.png')) ?>"> In-depth data analysis</div>
                        </div>
                        <a href="https://wpranktracker.com/" target="_blank" class="wprt_button_secondary wprt_activation_package_button">Choose Plan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>