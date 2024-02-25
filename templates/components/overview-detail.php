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
        <div class="wprt_overview_logo">
            <img src="<?php echo esc_url($iconHelper->getIconUrl('overview-detail-icon.png')) ?>">
        </div>
        <div class="wprt_overview_right">
            <div class="wprt_overview_title">
                <?php esc_html_e(sprintf('%s Analyze', $keyword->keyword), 'easy-rank-tracker'); ?>
            </div>
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
                        <div class="wprt_overview_box_count wprt_overview_box_rank <?php echo esc_attr($className) ?>">
                            <?php if ($keywordStatus['arrow'] === '--up') : ?>
                                <div class="wprt_overview_box_count up">
                                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
                                    <span><?php echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $keywordStatus['difference'] + (int) $keywordStatus['rank']))); ?></span>
                                </div>
                            <?php elseif ($keywordStatus['arrow'] === '--down') : ?>
                                <div class="wprt_overview_box_count down">
                                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
                                    <span><?php echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $keywordStatus['rank']) - (int) $keywordStatus['difference'])); ?></span>
                                </div>
                            <?php else : ?>
                                <div class="wprt_overview_box_count">
                                    -
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="wprt_overview_box_icon">
                        <img src="<?php echo esc_url($iconHelper->getIconUrl($iconName)) ?>">
                    </span>
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
                        <div class="wprt_overview_box_count wprt_overview_box_rank <?php echo esc_attr($className) ?>">
                            <?php if ($keywordStatus['arrow'] === '--up') : ?>
                                <div class="wprt_overview_box_count up">
                                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
                                    <span><?php echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $keywordStatus['difference'] + (int) $keywordStatus['rank']))); ?></span>
                                </div>
                            <?php elseif ($keywordStatus['arrow'] === '--down') : ?>
                                <div class="wprt_overview_box_count down">
                                    <?php echo esc_html((int) $keywordStatus['difference']); ?>
                                    <span><?php echo esc_html(sprintf(__("from %s", 'easy-rank-tracker'), ((int) $keywordStatus['rank']) - (int) $keywordStatus['difference'])); ?></span>
                                </div>
                            <?php else : ?>
                                <div class="wprt_overview_box_count">
                                    -
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="wprt_overview_box_icon">
                        <img src="<?php echo esc_url($iconHelper->getIconUrl($iconName)) ?>">
                    </span>
                </div>
                <div class="wprt_overview_box">
                    <div class="wprt_overview_box_title">
                        <?php esc_html_e('Last Keyword Check', 'easy-rank-tracker') ?>
                    </div>
                    <div class="wprt_overview_box_count">
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
            </div>
        </div>
    </div>
</div>
