<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

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
                <p class="wprt_alert wprt_alert--error">
                    <?php
                    /* translators: 1: Login URL */
                    printf( __( 'You have reached your daily keywords limit. Please consider <a href="%1$s">upgrading</a> your package.', 'easy-rank-tracker' ), esc_url_raw( admin_url( 'admin.php?page=wp-rank-tracker-premium' ) ) );
                    ?>
                </p>
            </div>
        <?php endif ?>
        <table id="wprt_keyword_list_table" class="uk-table uk-table-hover wprt_keyword_list_table">
            <thead>
            <tr>
                <th><?php esc_html_e('Keyword', 'easy-rank-tracker'); ?></th>
	            <th><?php esc_html_e('Position', 'easy-rank-tracker'); ?></th>
	            <th><?php esc_html_e('Location', 'easy-rank-tracker'); ?></th>
                <th><?php esc_html_e('Last Check', 'easy-rank-tracker'); ?></th>
                <th><?php esc_html_e('Actions', 'easy-rank-tracker'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php
            if (!empty($keywords)) :
                foreach ($keywords as $keyword) :
                    ?>
                    <tr class="wprt_keyword_list_table_row
                    wprt_keyword_list_table_row<?php echo esc_html($keyword->arrow); ?>"
                        data-keyword-id="<?php echo esc_attr($keyword->id); ?>" data-keyword-name="<?php echo esc_attr($keyword->keyword); ?>">
                        <td>
                            <a href="<?php echo esc_url(admin_url('admin.php?page=wp-rank-tracker&id=' . $keyword->id)); ?>" class="wprt_keyword_list_table_keyword">
                                <?php echo esc_html($keyword->keyword); ?>
                            </a>
                        </td>
	                    <td>
		                    <div class="wprt_keyword_list_table_position_current">
                                <?php echo esc_html($keyword->rank); ?>
			                    <?php if ($keyword->arrow === '--up') : ?>
				                    <div class="wprt_keyword_list_table_position_diff up">
					                    <span>
						                    <svg class="position-up" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keyword->difference); ?>
					                    </span>
				                    </div>
			                    <?php elseif ($keyword->arrow === '--down') : ?>
				                    <div class="wprt_keyword_list_table_position_diff down">
					                    <span>
						                    <svg class="position-down" height="5px" width="8px" viewBox="0 0 8 5"><path d="M0 0H8L4 5L0 0Z"></path></svg>
						                    <?php echo esc_html((int) $keyword->difference); ?>
					                    </span>
				                    </div>
			                    <?php endif; ?>
		                    </div>
	                    </td>
                        <td class="wprt_keyword_list_country">
                            <?php echo esc_html($iconHelper->getFlagByCountry($keyword->country)); ?>
                        </td>
                        <td class="wprt_keyword_list_table_last_check">
                            <?php echo esc_html($userTimeZoneHelper->getUserDate($keyword->last_update_date)); ?>
                        </td>
                        <td>
                            <div class="wprt_keyword_list_table_buttons">
                                <img src="<?php echo esc_url($iconHelper->getIconUrl('three-dot.svg')) ?>">
                            </div>
                            <div class="wprt_keyword_list_table_submenu">
                                <div class="wprt_update_icon <?php echo $limitIsFull ? 'disabled' : '' ?>">
                                    <?php esc_html_e('Update', 'easy-rank-tracker') ?>
                                </div>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=wp-rank-tracker&id=' . $keyword->id)); ?>">
                                    <?php esc_html_e('Check History', 'easy-rank-tracker') ?>
                                </a>
                                <div class="wprt_keyword_list_table_delete_icon">
                                    <?php esc_html_e('Delete', 'easy-rank-tracker') ?>
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
