<?php

/**
 * Keywords Page
 */

$userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');
$iconHelper = wprtContainer('IconHelper');

?>

<div class="wprt_keyword">
    <?php
    require 'header.php';
    $limitIsFull = false;
    require 'components/add-keywords.php';
    ?>
    <div class="wprt_keyword_list_wrapper">
        <?php
            require 'components/overview.php';
        ?>
        <?php if (get_transient('wprt_api_limit_check') === '0') : ?>
            <?php $limitIsFull = true; ?>
            <div class="wprt_activation_symbol">
                <p class="wprt_alert wprt_alert--warning">
                    <?php esc_html_e('Daily Request Limit is over, please upgrade your package.', WPRT_TRANSLATE) ?>
                </p>
            </div>
        <?php endif ?>
        <table id="wprt_keyword_list_table" class="uk-table uk-table-hover wprt_keyword_list_table">
            <thead>
            <tr>
                <th><?php esc_html_e('Keyword', WPRT_TRANSLATE); ?></th>
                <th><?php esc_html_e('Location', WPRT_TRANSLATE); ?></th>
                <th><?php esc_html_e('Position', WPRT_TRANSLATE); ?></th>
                <th><?php esc_html_e('Status', WPRT_TRANSLATE); ?></th>
                <th><?php esc_html_e('Last Check', WPRT_TRANSLATE); ?></th>
                <th><?php esc_html_e('Actions', WPRT_TRANSLATE); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            if (!empty($keywords)) :
                foreach ($keywords as $keyword) :
                    ?>
                    <tr class="wprt_keyword_list_table_row
                    wprt_keyword_list_table_row<?php echo esc_html($keyword->arrow); ?>"
                        data-keyword-id="<?php esc_attr_e($keyword->id); ?>" data-keyword-name="<?php esc_attr_e($keyword->keyword); ?>">
                        <td>
                            <span class="wprt_keyword_list_table_keyword">
                                <?php esc_html_e($keyword->keyword); ?>
                            </span>
                        </td>
                        <td class="wprt_keyword_list_country">
                            <?php esc_html_e($iconHelper->getFlagByCountry($keyword->country)); ?>
                        </td>
                        <td>
                            <div class="wprt_keyword_list_table_position_current">
                                <?php esc_html_e($keyword->rank); ?>
                            </div>
                        </td>
                        <td>
                            <?php if ($keyword->arrow === '--up') : ?>
                                <div class="wprt_keyword_list_table_status up">
                                    <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-up.png')) ?>">
                                    <span><?php esc_html_e((int) $keyword->difference); ?></span>
                                    <?php esc_html_e(sprintf(__("from %s", WPRT_TRANSLATE), ((int) $keyword->difference + (int) $keyword->rank))); ?>
                                </div>
                            <?php elseif ($keyword->arrow === '--down') : ?>
                                <div class="wprt_keyword_list_table_status down">
                                    <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-down.png')) ?>">
                                    <span><?php esc_html_e((int) $keyword->difference); ?></span>
                                    <?php esc_html_e(sprintf(__("from %s", WPRT_TRANSLATE), ((int) $keyword->rank) - (int) $keyword->difference)); ?>
                                </div>
                            <?php else : ?>
                                <div class="wprt_keyword_list_table_status">
                                    <img src="<?php echo esc_url($iconHelper->getIconUrl('arrow-no-change.png')) ?>">
                                    -
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="wprt_keyword_list_table_last_check">
                            <?php esc_html_e($userTimeZoneHelper->getUserDate($keyword->last_update_date)); ?>
                        </td>
                        <td>
                            <div class="wprt_keyword_list_table_buttons">
                                <img src="<?php echo esc_url($iconHelper->getIconUrl('three-dot.svg')) ?>">
                            </div>
                            <div class="wprt_keyword_list_table_submenu">
                                <div class="wprt_update_icon <?php echo $limitIsFull ? 'disabled' : '' ?>">
                                    <?php esc_html_e('Update', WPRT_TRANSLATE) ?>
                                </div>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=wp-rank-tracker&id=' . $keyword->id)); ?>">
                                    <?php esc_html_e('Check History', WPRT_TRANSLATE) ?>
                                </a>
                                <div class="wprt_keyword_list_table_delete_icon">
                                    <?php esc_html_e('Delete', WPRT_TRANSLATE) ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?>
            </tbody>
        </table>
    </input>
</div>
