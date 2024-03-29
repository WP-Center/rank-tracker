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

$queriedKeywordId = $pageHelper->getQueriedKeyword();
$keywords = $rankController->getDifferenceRowsFromKeyword($queriedKeywordId);
$totalRanks = count($keywords);

$chartXData = '';
$chartYData = '';

foreach ($keywords as $index => $rank) {
    if ($rank->ranks === 'Not Exist') {
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
        <div class="wprt_keyword_datepicker_wrapper">
            <input class="wprt_keyword_datepicker">
        </div>
        <?php require 'components/overview-detail.php'; ?>
        <div class="wprt_keyword_list_detail_wrapper">
            <table id="wprt_keyword_list_detail_table" class="uk-table uk-table-hover uk-table-striped wprt_keyword_list_table">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Date', 'easy-rank-tracker'); ?></th>
                        <th><?php esc_html_e('Position', 'easy-rank-tracker'); ?></th>
                        <th><?php esc_html_e('Status', 'easy-rank-tracker'); ?></th>
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
                                <span class="wprt_keyword_list_table_keyword">
                                    <?php echo esc_html($rank->ranks); ?>
                                </span>
                            </td>

                            <td class="wprt_keyword_list_table_row<?php echo esc_html($rank->arrow); ?>">
                                <div class="wprt_keyword_list_table_position_diff<?php echo esc_html($rank->arrow); ?>">
                                    <?php if ($rank->arrow === '--up') : ?>
                                        <div class="wprt_keyword_list_table_status up">
                                            <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-up.png')) ?>">
                                            <span><?php echo esc_html((int) $rank->difference); ?></span>
                                            <?php
                                            /* translators: %s: Keyword Difference Count */
                                            echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $rank->difference + (int) $rank->ranks))); ?>
                                        </div>
                                    <?php elseif ($rank->arrow === '--down') : ?>
                                        <div class="wprt_keyword_list_table_status down">
                                            <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-down.png')) ?>">
                                            <span><?php echo esc_html((int) $rank->difference); ?></span>
                                            <?php
                                            /* translators: %s: Keyword Difference Count */
                                            echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $rank->ranks) - (int) $rank->difference)); ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="wprt_keyword_list_table_status">
                                            <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-no-change.png')) ?>">
                                            -
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

            <?php if (!empty($chartYData)) : ?>
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