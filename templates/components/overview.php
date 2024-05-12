<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Overview
 */

$userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');
$iconHelper = wprtContainer('IconHelper');
$licenseHelper = wprtContainer('LicenseHelper');
$userTypeHelper = wprtContainer('UserTypeHelper');
$databaseHelper = wprtContainer('DatabaseHelper');
$keywordHelper = wprtContainer('KeywordHelper');

?>
<div class="wprt_overview">
    <div class="wprt_overview_title">
        <?php esc_html_e('Overview', 'easy-rank-tracker') ?>
    </div>
    <div class="wprt_overview_container">
        <div class="wprt_overview_boxes wprt_overview_boxes_third">
            <div class="wprt_overview_box">
	            <div>
		            <div class="wprt_overview_box_title">
			            <?php esc_html_e('Total Keyword Count', 'easy-rank-tracker') ?>
		            </div>
		            <div class="wprt_overview_box_count">
			            <?php echo esc_html(count($databaseHelper->getRow('keywords'))) ?>
		            </div>
	            </div>
	            <div class="wprt_overview_box_icon">
		            <?php echo esc_url($iconHelper->getIcon('total-keyword-count.svg')) ?>
	            </div>
            </div>
            <div class="wprt_overview_box">
	            <div>
		            <div class="wprt_overview_box_title">
			            <?php esc_html_e('Daily Request', 'easy-rank-tracker') ?>
		            </div>
		            <div class="wprt_overview_box_count">
			            <?php echo esc_html((in_array(get_transient('wprt_api_limit_check'), [false, '']) ? '0' : get_transient('wprt_api_limit_check'))) ?>
			            <span>
                         <?php echo esc_html(sprintf('left/ %s total', in_array(get_transient('wprt_api_package_limit'), [false, '']) ? '0' : get_transient('wprt_api_package_limit')), 'easy-rank-tracker'); ?>
                        </span>
		            </div>
	            </div>
	            <div class="wprt_overview_box_icon">
		            <?php echo esc_url($iconHelper->getIcon('daily-request.svg')) ?>
	            </div>
            </div>
            <div class="wprt_overview_box">
	            <div>
		            <div class="wprt_overview_box_title">
			            <?php esc_html_e('License Remaining Day', 'easy-rank-tracker') ?>
		            </div>
		            <div class="wprt_overview_box_count">
			            <?php
			            if ($userTypeHelper->isFree()) {
				            esc_html_e('∞', 'easy-rank-tracker');
			            } else {
				            echo esc_html($licenseHelper->getLicenseRemainingDay());
				            ?>
				            <span>
                            <?php esc_html_e('days', 'easy-rank-tracker'); ?>
                        </span>
				            <?php
			            }
			            ?>
		            </div>
	            </div>
	            <div class="wprt_overview_box_icon">
		            <?php echo esc_url($iconHelper->getIcon('update-with-clock.svg')) ?>
	            </div>
            </div>
            <div class="wprt_overview_box rank">
                <div>
                    <div class="wprt_overview_box_title">
                        <?php esc_html_e('7 Days Average', 'easy-rank-tracker') ?>
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
                        <span class="wprt_overview_box_keyword_up">
                            <?php
                                printf(
                                    /* translators: %s: Keyword Count */
                                    esc_html__( '%s keywords going up', 'easy-rank-tracker' ),
                                    esc_html( count($keywordStatus['upKeywords']))
                                );
                            ?>
                        </span>
                        <br>
                        <span class="wprt_overview_box_keyword_down">
                            <?php
                                printf(
                                    /* translators: %s: Keyword Count */
                                    esc_html__( '%s keywords going down', 'easy-rank-tracker' ),
                                    esc_html( count($keywordStatus['downKeywords']))
                                );
                            ?>
                        </span>
                    </div>
                </div>
	            <div class="wprt_overview_box_icon">
		            <?php echo esc_url($iconHelper->getIcon('7-days.svg')) ?>
	            </div>
            </div>
            <div class="wprt_overview_box rank">
                <div>
                    <div class="wprt_overview_box_title">
                        <?php esc_html_e('30 Days Average', 'easy-rank-tracker') ?>
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
                        <span class="wprt_overview_box_keyword_up">
                            <?php
                                printf(
                                /* translators: %s: Keyword Count */
                                    esc_html__( '%s keywords going up', 'easy-rank-tracker' ),
                                    esc_html( count($keywordStatus['upKeywords']))
                                );
                            ?>
                        </span>
                        <br>
                        <span class="wprt_overview_box_keyword_down">
	                        <?php
	                            printf(
	                                /* translators: %s: Keyword Count */
	                                esc_html__( '%s keywords going down', 'easy-rank-tracker' ),
	                                esc_html( count($keywordStatus['downKeywords']))
	                            );
	                        ?>
                        </span>
                    </div>
                </div>
	            <div class="wprt_overview_box_icon">
		            <?php echo esc_url($iconHelper->getIcon('30-days.svg')) ?>
	            </div>
            </div>
	        <div class="wprt_overview_box">
		        <div>
			        <div class="wprt_overview_box_title">
				        <?php esc_html_e('Last Updated', 'easy-rank-tracker') ?>
			        </div>
			        <div class="wprt_overview_box_content">
				        <?php
				        $keywordsAll = $keywordHelper->getKeywordsLastCheck();
				        if (isset($keywordsAll[0])) {
					        $lastCheck = $keywordsAll[0]['last_update_date'];
					        echo esc_html($userTimeZoneHelper->getUserDate($lastCheck, true, 'd M Y'));
					        ?>
					        <?php
				        } else {
					        esc_html_e('No Keywords', 'easy-rank-tracker');
				        }
				        ?>
			        </div>
		        </div>
		        <div class="wprt_overview_box_icon">
			        <?php echo esc_url($iconHelper->getIcon('update-with-clock.svg')) ?>
		        </div>
	        </div>
        </div>
    </div>
</div>
