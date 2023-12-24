<?php

/**
 * Overview
 */
 
$iconHelper = wprtContainer('IconHelper');
$licenseHelper = wprtContainer('LicenseHelper');
$userTypeHelper = wprtContainer('UserTypeHelper');
$databaseHelper = wprtContainer('DatabaseHelper');
$keywordHelper = wprtContainer('KeywordHelper');

?>
<div class="wprt_overview">
    <div class="wprt_overview_title">
        <?php esc_html_e('Overview', WPRT_TRANSLATE) ?>
    </div>
    <div class="wprt_overview_container">
        <div class="wprt_overview_logo">
            <img src="<?php echo esc_url($iconHelper->getIconUrl('overview.png')) ?>">
        </div>
        <div class="wprt_overview_boxes">
            <div class="wprt_overview_box">
                <div class="wprt_overview_box_title">
                    <?php esc_html_e('Total Keyword Count', WPRT_TRANSLATE) ?>
                </div>
                <div class="wprt_overview_box_count">
                    <?php esc_html_e(count($databaseHelper->getRow('keywords'))) ?>
                </div>
            </div>
            <div class="wprt_overview_box">
                <div class="wprt_overview_box_title">
                    <?php esc_html_e('Daily Request', WPRT_TRANSLATE) ?>
                </div>
                <div class="wprt_overview_box_count">
                    <?php esc_html_e((in_array(get_transient('wprt_api_limit_check'), [false, '']) ? '0' : get_transient('wprt_api_limit_check'))) ?>
                    <span>
                        <?php esc_html_e(sprintf('left/ %s total', in_array(get_transient('wprt_api_package_limit'), [false, '']) ? '0' : get_transient('wprt_api_package_limit')), WPRT_TRANSLATE); ?>
                    </span>
                </div>
            </div>
            <div class="wprt_overview_box">
                <div class="wprt_overview_box_title">
                    <?php esc_html_e('License Remaining Day', WPRT_TRANSLATE) ?>
                </div>
                <div class="wprt_overview_box_count">
                    <?php
                    if ($userTypeHelper->isFree()) {
                        esc_html_e('∞', WPRT_TRANSLATE);
                    } else {
                        esc_html_e($licenseHelper->getLicenseRemainingDay());
                        ?>
                        <span>
                            <?php esc_html_e('days', WPRT_TRANSLATE); ?>
                        </span>
                        <?php
                    } 
                    ?>
                </div>
            </div>
            <div class="wprt_overview_box rank">
                <div>
                    <div class="wprt_overview_box_title">
                        <?php esc_html_e('7 Days Average', WPRT_TRANSLATE) ?>
                    </div>
                    <?php
                    $keywordStatus = $keywordHelper->getTotalKeywordStasus("-7 days");
                    $className = '';
                    $iconName = 'arrow-up.png';
                    if (count($keywordStatus['downKeywords']) > count($keywordStatus['upKeywords'])) {
                        $className = 'reverse';
                        $iconName = 'arrow-down.png';
                    }
                    ?>
                    <div class="wprt_overview_box_count wprt_overview_box_rank <?php echo esc_attr($className) ?>">
                        <span class="wprt_overview_box_keyword_up"><?php esc_html_e(sprintf('%s keywords going up', count($keywordStatus['upKeywords'])), WPRT_TRANSLATE); ?></span>
                        <span class="wprt_overview_box_keyword_down"><?php esc_html_e(sprintf('%s keywords going down', count($keywordStatus['downKeywords'])), WPRT_TRANSLATE); ?></span>
                    </div>
                </div>
                <span class="wprt_overview_box_icon">
                    <img src="<?php echo esc_url($iconHelper->getIconUrl($iconName)) ?>">
                </span>
            </div>
            <div class="wprt_overview_box rank">
                <div>
                    <div class="wprt_overview_box_title">
                        <?php esc_html_e('30 Days Average', WPRT_TRANSLATE) ?>
                    </div>
                    <?php
                    $keywordStatus = $keywordHelper->getTotalKeywordStasus("-30 days");
                    $className = '';
                    $iconName = 'arrow-up.png';
                    if (count($keywordStatus['downKeywords']) > count($keywordStatus['upKeywords'])) {
                        $className = 'reverse';
                        $iconName = 'arrow-down.png';
                    }
                    ?>
                    <div class="wprt_overview_box_count wprt_overview_box_rank <?php echo esc_attr($className) ?>">
                        <span class="wprt_overview_box_keyword_up"><?php esc_html_e(sprintf('%s keywords going up', count($keywordStatus['upKeywords'])), WPRT_TRANSLATE); ?></span>
                        <span class="wprt_overview_box_keyword_down"><?php esc_html_e(sprintf('%s keywords going down', count($keywordStatus['downKeywords'])), WPRT_TRANSLATE); ?></span>
                    </div>
                </div>
                <span class="wprt_overview_box_icon">
                    <img src="<?php echo esc_url($iconHelper->getIconUrl($iconName)) ?>">
                </span>
            </div>
            <div class="wprt_overview_box">
                <div class="wprt_overview_box_title">
                    <?php esc_html_e('Last Keyword Check', WPRT_TRANSLATE) ?>
                </div>
                <div class="wprt_overview_box_count">
                    <?php
                    $keywordsAll = $keywordHelper->getKeywordsLastCheck();
                    if (isset($keywordsAll[0])) {
                        $lastCheck = $keywordsAll[0]['last_update_date'];
                        echo esc_html(wp_date("d M Y", $lastCheck, wp_timezone()));
                        ?>
                        <span>
                                <?php echo esc_html(wp_date('g:i:a', $lastCheck, wp_timezone())); ?>
                            </span>
                        <?php
                    } else {
                        esc_html_e('No Keywords', WPRT_TRANSLATE);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
