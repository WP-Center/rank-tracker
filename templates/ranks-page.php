<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ranks Page
 */

$rankController = wprtContainer('RankController');
$pageHelper = wprtContainer('PageHelper');
$iconHelper = wprtContainer('IconHelper');
$keywordController = wprtContainer('GetKeywordsController');

$queriedKeywordId = $pageHelper->getQueriedKeyword();
$keywords = $rankController->getDifferenceRowsFromKeyword($queriedKeywordId);
$keyword = $keywordController->getKeywordById($queriedKeywordId);
$totalRanks = count($keywords);

$chartXData = '';
$chartYData = '';

$chardData = array_reverse($keywords);
foreach ($chardData as $index => $rank) {
    if ($rank->ranks === '> 100') {
        continue;
    }

    $chartXData .= wp_date('d M', strtotime($rank->created_at), wp_timezone());
    $chartYData .= $rank->ranks;

    $chartXData .= ',';
    $chartYData .= ',';
}
$chartXData = rtrim($chartXData, ',');
$chartYData = rtrim($chartYData, ',');
?>

<div class="wprt_keyword">
    <?php require 'header.php'; ?>
    <div class="wprt_keyword_list_wrapper wprt_keyword_list_detail">
        <div class="wprt_keyword_datepicker_wrapper_detail">
	        <div class="wprt_overview_title">
		        <?php
		        printf(
		        /* translators: %s: Keyword of the shown details */
			        esc_html__( '"%s" Keyword History', 'easy-rank-tracker' ),
			        esc_html($keyword->keyword)
		        );
		        ?>
	        </div>
	        <div class="wprt_keyword_datepicker_wrapper">
		        <input class="wprt_keyword_datepicker">
	        </div>
        </div>
        
        <?php require 'components/overview-detail.php'; ?>
        <div class="wprt_keyword_list_detail_wrapper">
            <table id="wprt_keyword_list_detail_table" class="uk-table uk-table-hover uk-table-striped wprt_keyword_list_table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Date', 'easy-rank-tracker'); ?></th>
                        <th><?php esc_html_e('Position', 'easy-rank-tracker'); ?></th>
                    </tr>
                </thead>

                <tbody>
                <?php
                if (!empty($keywords)) :
                    foreach ($keywords as $rank) :
                        ?>
                        <tr class="wprt_keyword_list_table_row wprt_keyword_list_table_row">
                            <td>
                                <span class="wprt_keyword_list_table_keyword">
                                    <?php echo esc_html(wp_date('d M Y', strtotime($rank->created_at), wp_timezone())); ?>
                                </span>
                            </td>
                            <td>
	                            <div class="wprt_keyword_list_table_position_current">
		                            <?php echo esc_html($rank->ranks); ?>
		                            <?php if ($rank->arrow === '--up') : ?>
			                            <div class="wprt_keyword_list_table_position_diff up">
					                    <span>
						                    <svg class="position-up" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $rank->difference); ?>
					                    </span>
			                            </div>
		                            <?php elseif ($rank->arrow === '--down') : ?>
			                            <div class="wprt_keyword_list_table_position_diff down">
					                    <span>
						                    <svg class="position-down" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $rank->difference); ?>
					                    </span>
			                            </div>
		                            <?php endif; ?>
	                            </div>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
            

            <?php if (!empty($chartYData)) :?>
                <div class="wprt_keyword_list_chart">
                    <canvas id="rankChart"
                        data-rank-x-value="<?php echo esc_attr($chartXData); ?>"
                        data-rank-y-value="<?php echo esc_attr($chartYData); ?>"
                    ></canvas>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>