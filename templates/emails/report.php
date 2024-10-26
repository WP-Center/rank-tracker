<!-- body -->
<div style="background-color: #edf2f7; padding: 0 30px;">
    <!-- header -->
    <div style="padding: 20px 0" >
        <a href="<?php echo esc_url('https://wpranktracker.com/?utm_source=wprt-email&utm_medium=rank-tracker&utm_campaign=landing-page') ?>" target="_blank">
            <img
                src="<?php echo esc_url($logoUrl) ?>"
                width="200"
                height="40"
                alt="Logo"
                style="margin-left: auto; margin-right: auto; display: block; object-fit: contain;"
            />
        </a>
    </div>

    <!-- content card -->
    <div class="content" style="background-color: #fff; padding: 20px; border-radius: 5px; max-width: 400px; margin-left: auto; margin-right: auto;">
        <p
            style="color: #555;"
        >
            <?php esc_html_e( 'Hello,', 'easy-rank-tracker' );?><br>
            <?php printf( esc_html__('Here\'s a look how your %s website has been ranking so far %s.', 'easy-rank-tracker' ), 
                sprintf(
                    '<a href="%s">%s</a>',
                   esc_url(site_url()),
                   esc_html(site_url())
                ),
	            (isset($frequencyTitle[ $frequency ]) && !empty($frequencyTitle[ $frequency ] )) ? $frequencyTitle[ $frequency ] : 'since last time' 
            )?>
            <br><br>
            <strong><?php esc_html_e( sprintf( '%s Report: %s', ucfirst( $frequency ), $dateTitle ), 'easy-rank-tracker' )?></strong>
            <!-- keywords overview -->
            <div style="margin-bottom: 5px;">
                <div style="display: inline-block; max-width: 50%; width: calc(40% + 5px); border: 1px solid #edf2f9; border-radius: 5px; padding: 0 15px;">
                    <p style="color: #5AB267;"><strong><?php printf('%d keywords going up', count($keywords['upKeywords'])) ?></strong></p>
                </div>
                <div style="display: inline-block; max-width: 50%;  width: calc(40% + 5px); border: 1px solid #edf2f9; border-radius: 5px; padding: 0 15px;">
                    <p style="color: #E63A57;"><strong><?php printf('%d keywords going down', count($keywords['downKeywords'])) ?></strong></p>
                </div>
            </div>
            <div style="margin-bottom: 5px;">
                <div style="display: inline-block; max-width: 50%;  width: calc(40% + 5px); border: 1px solid #edf2f9; border-radius: 5px; padding: 0 15px;">
                    <p style="color: #3ebef2;"><strong><?php printf('%d keywords unchanged', count($keywords['unchangedKeywords'])) ?></strong></p>
                </div>
                <div style="display: inline-block; max-width: 50%;  width: calc(40% + 5px); border: 1px solid #edf2f9; border-radius: 5px; padding: 0 15px;">
                    <p style="color: #3ebef2;"><strong><?php printf('%d keywords > 100', count($keywords['unrankedKeywords'])) ?></strong></p>
                </div>
            </div>
            <!-- keywords list -->
            <div style="border: 1px solid #edf2f9; border-radius: 5px; padding: 15px; margin-bottom: 20px;">
                <h4 style="margin: 0;">Keywords (<?php echo count($keywords['allKeywords']) ?>)</h4>
                <table style="border-collapse: collapse; width: 100%;" border="0">
                    <tbody>
                        <?php foreach($keywords['allKeywords'] as $keyword): ?>
                            <tr>
                                <td>
                                    <?php echo esc_html( $keyword->keyword ) ?>
                                </td>
                                <td>
                                    <?php echo esc_html( $keyword->rank ) ?>
                                    &nbsp;
                                    <span style="font-size: .9em; color: <?php echo esc_attr($keyword->color) ?>; background-color: <?php echo esc_attr($keyword->color) ?>20; display: inline-block; border-radius: 5px; padding: 0 4px;">
                                        <?php if($keyword->status === 'up'): ?>
                                            <img width="8" src="<?php echo esc_url('https://wpranktracker.com/wp-content/uploads/2024/08/arrow-up.png') ?>" alt="<?php esc_attr_e('Up', 'easy-rank-tracker') ?>">
                                        <?php elseif($keyword->status === 'down'): ?>
                                            <img width="8" src="<?php echo esc_url('https://wpranktracker.com/wp-content/uploads/2024/08/arrow-down.png') ?>" alt="<?php esc_attr_e('Down', 'easy-rank-tracker') ?>">
                                        <?php endif; ?>
                                        <?php esc_html_e( $keyword->difference, 'easy-rank-tracker' )?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- keywords list end -->
            <hr>
            <p
            style="color: #555;"
             >
             <?php
             printf(
                esc_html__(
                    'If you need to track more keywords, you can check%s⭐ %s ⭐%sIf you need help please check out our %s or %s',
                    'easy-rank-tracker',
                ),
                '<br>',
                sprintf(
                    '<a href="%s">%s</a>',
                    esc_url('https://wpranktracker.com/pricing/?utm_source=wprt-email&utm_medium=rank-tracker&utm_campaign=landing-page'),
                    esc_html__('WP Rank Tracker Premium Packages', 'easy-rank-tracker')
                ),
                '<br>',
                sprintf(
                        '<a href="%s">%s</a>',
                        esc_url('https://docs.wpranktracker.com/?utm_source=wprt-email&utm_medium=rank-tracker&utm_campaign=landing-page'),
                        esc_html__('Documentation', 'easy-rank-tracker')
                ),
                sprintf(
                        '<a href="%s">%s</a>',
                        esc_url('https://wpranktracker.com/contact-us/?utm_source=wprt-email&utm_medium=rank-tracker&utm_campaign=landing-page'),
                        esc_html__('contact us', 'easy-rank-tracker')
                )
             )
             ?>
             <br><br>
             <?php esc_html_e('If you want to change the frequency of this report, you can always do it in the WP Rank Tracker plugin’s settings page.', 'easy-rank-tracker') ?>
             <br><br>
             <?php printf(
                '<a href="%s">%s</a>',
                esc_url('https://wpranktracker.com/?utm_source=wprt-email&utm_medium=rank-tracker&utm_campaign=landing-page'),
                esc_html__('The Rank Tracker Team', 'easy-rank-tracker')
             ) ?>
             </p>
        </p>
    </div>
    <!-- footer -->
     <div>
        <p
        style="color: #555; text-align: center; font-size: 10px; padding: 40px 0; margin: 0;"
        >
        <?php esc_html_e( sprintf( '© %s Rank Tracker. All rights reserved', date( 'Y' ) ) )?>
        </p>
     </div>
</div>