<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Overview
 */

$iconHelper = wprtContainer('IconHelper');
$licenseHelper = wprtContainer('LicenseHelper');
$userTypeHelper = wprtContainer('UserTypeHelper');
$databaseHelper = wprtContainer('DatabaseHelper');
$keywordHelper = wprtContainer('KeywordHelper');
$pageHelper = wprtContainer('PageHelper');
$keywordController = wprtContainer('GetKeywordsController');
$queriedKeywordId = $pageHelper->getQueriedKeyword();
$keyword = $keywordController->getKeywordById($queriedKeywordId);

?>
<div class="wprt_overview wprt_overview_detail">
    <div class="wprt_overview_container">
        <div class="wprt_overview_right">
            <div class="wprt_overview_boxes">
	            <div class="wprt_overview_box rank">
		            <div>
			            <div class="wprt_overview_box_title">
				            <?php esc_html_e('7 Days Average', 'easy-rank-tracker') ?>
			            </div>
			            <?php
			            $keywordStatus = $keywordHelper->getKeywordStatus("-7 days", $queriedKeywordId);
			            $className = '';
			            $iconName = 'arrow-no-change.png';
			            if ($keywordStatus['arrow'] === '--up') {
				            $iconName = 'arrow-up.png';
			            } elseif ($keywordStatus['arrow'] === '--down') {
				            $className = 'reverse';
				            $iconName = 'arrow-down.png';
			            }

			            ?>
			            <div class="wprt_keyword_list_table_position_current wprt_overview_box_content">
				            <?php echo esc_html((int) $keywordStatus['rank']); ?>
				            <?php if ($keywordStatus['arrow'] === '--up') : ?>
					            <div class="wprt_keyword_list_table_position_diff up">
					                    <span>
						                    <svg class="position-up" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php elseif ($keywordStatus['arrow'] === '--down') : ?>
					            <div class="wprt_keyword_list_table_position_diff down">
					                    <span>
						                    <svg class="position-down" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php endif; ?>
			            </div>
		            </div>
		            <div class="wprt_overview_box_icon">
			            <?php echo esc_url($iconHelper->getIcon('trend-up.svg')) ?>
                    </div>
	            </div>
	            <div class="wprt_overview_box rank">
		            <div>
			            <div class="wprt_overview_box_title">
				            <?php esc_html_e('30 Days Average', 'easy-rank-tracker') ?>
			            </div>
			            <?php
			            $keywordStatus = $keywordHelper->getKeywordStatus("-30 days", $queriedKeywordId);
			            $className = '';
			            $iconName = 'arrow-no-change.png';
			            if ($keywordStatus['arrow'] === '--up') {
				            $iconName = 'arrow-up.png';
			            } elseif ($keywordStatus['arrow'] === '--down') {
				            $className = 'reverse';
				            $iconName = 'arrow-down.png';
			            }

			            ?>
			            <div class="wprt_keyword_list_table_position_current wprt_overview_box_content">
				            <?php echo esc_html((int) $keywordStatus['rank']); ?>
				            <?php if ($keywordStatus['arrow'] === '--up') : ?>
					            <div class="wprt_keyword_list_table_position_diff up">
					                    <span>
						                    <svg class="position-up" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php elseif ($keywordStatus['arrow'] === '--down') : ?>
					            <div class="wprt_keyword_list_table_position_diff down">
					                    <span>
						                    <svg class="position-down" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php endif; ?>
			            </div>
		            </div>
		            <div class="wprt_overview_box_icon">
			            <?php echo esc_url($iconHelper->getIcon('trend-up.svg')) ?>
		            </div>
	            </div>
	            <div class="wprt_overview_box">
		            <div>
			            <div class="wprt_overview_box_title">
				            <?php esc_html_e('Last Keyword Check', 'easy-rank-tracker') ?>
			            </div>
			            <div class="wprt_overview_box_content">
				            <?php
				            if ($keyword->last_update_date) {
					            echo esc_html(wp_date("d M Y", $keyword->last_update_date, wp_timezone()));
					            ?>
					            <span>
                                <?php echo esc_html(wp_date('g:i:a', $keyword->last_update_date, wp_timezone())); ?>
                            </span>
					            <?php
				            } else {
					            esc_html_e('Rank value not checked yet', 'easy-rank-tracker');
				            }
				            ?>
			            </div>
		            </div>
		            <div class="wprt_overview_box_icon">
			            <?php echo esc_url($iconHelper->getIcon('trend-up.svg')) ?>
		            </div>
	            </div>
	            <div class="wprt_overview_box rank">
		            <div>
			            <div class="wprt_overview_box_title">
				            <?php esc_html_e('30 Days Average', 'easy-rank-tracker') ?>
			            </div>
			            <?php
			            $keywordStatus = $keywordHelper->getKeywordStatus("-30 days", $queriedKeywordId);
			            $className = '';
			            $iconName = 'arrow-no-change.png';
			            if ($keywordStatus['arrow'] === '--up') {
				            $iconName = 'arrow-up.png';
			            } elseif ($keywordStatus['arrow'] === '--down') {
				            $className = 'reverse';
				            $iconName = 'arrow-down.png';
			            }

			            ?>
			            <div class="wprt_keyword_list_table_position_current wprt_overview_box_content">
				            <?php echo esc_html((int) $keywordStatus['rank']); ?>
				            <?php if ($keywordStatus['arrow'] === '--up') : ?>
					            <div class="wprt_keyword_list_table_position_diff up">
					                    <span>
						                    <svg class="position-up" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php elseif ($keywordStatus['arrow'] === '--down') : ?>
					            <div class="wprt_keyword_list_table_position_diff down">
					                    <span>
						                    <svg class="position-down" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
					                    </span>
					            </div>
				            <?php endif; ?>
			            </div>
		            </div>
		            <div class="wprt_overview_box_icon">
			            <?php echo esc_url($iconHelper->getIcon('trend-up.svg')) ?>
		            </div>
	            </div>
            </div>
        </div>
    </div>
</div>
