<?php
namespace WPRankTracker\Modules\Cron;

class ReportSenderCronController
{
    /**
     * Hooks CRON actions to send report to admin for daily|weekly|monthly
     */
    public function __construct()
    {
        add_action( 'init', [ $this, 'scheduleNextReport' ] );
        add_filter( 'cron_schedules', [$this, 'addCronSchedules'] );
    }

    /**
     * Add custom schedules
     *
     * @param array $schedules
     * @return array
     */
    public function addCronSchedules(array $schedules): array
    {
        if( ! isset($schedules['monthly']) ){
            $schedules['monthly'] = [
                'interval' => MONTH_IN_SECONDS,
                'display' => __('Monthly', 'easy-rank-tracker'),
            ];
        }

        return $schedules;
    }

    /**
     * Get the date range for report as a title
     *
     * @param string $frequency
     * @return string
     */
    protected function getDateTitle( string $frequency ): string
    {
        $dateTitle = '';

        switch ( $frequency ) {
            case 'daily':
                $dateTitle = sprintf(
                    '%s - %s',
                    date( 'd F Y', strtotime( '-1 day', time() ) ),
                    date( 'd F Y', time() )
                );
                break;
            case 'weekly':
                $dateTitle = sprintf(
                    '%s - %s',
                    date( 'd F Y', strtotime( '-1 week', time() ) ),
                    date( 'd F Y', time() )
                );
                break;
            case 'monthly':
                $dateTitle = sprintf(
                    '%s - %s',
                    date( 'd F Y', strtotime( '-1 month', time() ) ),
                    date( 'd F Y', time() ),
                );
                break;
            default:break;
        }

        return $dateTitle;

    }

    /**
     * Get next cron schedule timestamp
     *
     * @param string $frequency
     * @return integer|boolean
     */
    protected function getNextReportTime( string $frequency ) : int
    {
        $stamp = '';

        switch ( $frequency ) {
            case 'daily':
                $stamp = strtotime( '+1 day ' . gmdate( 'H:i:s' ) );
                break;
            case 'weekly':
                $stamp = strtotime( '+1 week ' . gmdate( 'H:i:s' ) );
                break;
            case 'monthly':
                $stamp = strtotime( '+1 month ' . gmdate( 'H:i:s' ) );
                break;
            default:
                $stamp = strtotime( '+1 week ' . gmdate( 'H:i:s' ) );
                break;
        }

        return $stamp;
    }

    /**
     * Schedules cron jobs
     * Hooks cron action to send email report function
     *
     * @return void
     */
    public function scheduleNextReport(): void
    {
        $optionsHelper = wprtContainer( 'OptionsHelper' );
        $frequency     = $optionsHelper->getOption( 'notification_frequency' );
        $nextCron      = $this->getNextReportTime( $frequency );

        if(!$frequency){
            $frequency = 'weekly';
        }

        if ( !  wp_next_scheduled( 'wprt_rank_report_send' ) ) {
            wp_schedule_event( $nextCron, $frequency, 'wprt_rank_report_send' );
        }

        add_action( 'wprt_rank_report_send', [ $this, 'sendReportToEmail' ] );
        add_action( 'wprt_reset_report_cron', [ $this, 'clearScheduledReport' ] );
    }

    /**
     * Reset existing cron jobs using action hook
     * Usually going to be fire after update settings
     *
     * @return void
     */
    public function clearScheduledReport(): void
    {
        wp_clear_scheduled_hook( 'wprt_rank_report_send' );
    }

    /**
     * Get report from format to get report
     *
     * @param string $frequency
     * @return string
     */
    public function getReportFromFormat(string $frequency): string
    {
        $format =  '';

        switch($frequency){
            case 'daily':
                $format = '-1 day';
                break;
            case 'weekly':
                $format = '-7 days';
                break;
            case 'monthly': 
                $format = '-30 days';
                break;
            default: 
                $format = '-7 days';
                break;
            }

            return $format;
    }

    /**
     * Send report to email from settings
     * First gather report data and other information, then send email
     *
     * TODO: add email template
     *
     * @return void
     */
    public function sendReportToEmail(): void
    {
        $optionsHelper = wprtContainer( 'OptionsHelper' );
        $iconHelper = wprtContainer( 'IconHelper' );
        $keywordHelper = wprtContainer('KeywordHelper');

        $email     = $optionsHelper->getOption( 'notification_email' );
        $frequency = $optionsHelper->getOption( 'notification_frequency' );
        $email = empty( $email ) ? get_option('admin_email') : $email;
        
        if (  !  $email ) {
            return;
        }
        
        $frequencyTitle = [
            'daily'   => __('today', 'easy-rank-tracker'),
            'weekly'  => __('this week', 'easy-rank-tracker'),
            'monthly' => __('this month', 'easy-rank-tracker'),
        ];
        $dateTitle = $this->getDateTitle( $frequency );
        $logoUrl = 'https://wpranktracker.com/wp-content/uploads/2023/12/Group-4-1.png';

        $dateFromFormat = $this->getReportFromFormat($frequency);
        $this->updateLatestData($dateFromFormat);
        $keywords = $keywordHelper->getTotalKeywordStasus($dateFromFormat);

        if(count($keywords['allKeywords']) === 0){
            return;
        }

        // create buffer to render HTMLs
        ob_start();
        include WPRT_PLUGIN_DIR_PATH . 'templates/emails/report.php';
        $body = ob_get_clean();

        wp_mail(
            $email,
            __(sprintf( 'Rank Tracker - %s Report', ucfirst( $frequency ) ), 'easy-rank-tracker'),
            $body,
            'Content-Type: text/html; charset=UTF-8'
        );
    }

    /**
     * This function checks if ranks have latest data or not, if so then it updates
     * 
     * @return void
     */
    private function updateLatestData($dateFromFormat): void
    {
        $keywordHelper = wprtContainer('KeywordHelper');
        $userTimeZoneHelper = wprtContainer('UserTimeZoneHelper');
        $keywords = $keywordHelper->getKeywordsLastCheck();
        $dateNow = $userTimeZoneHelper->getUserDate('', false, 'Y-m-d H:i:s', true);
        $lastCheck = false;

        foreach ($keywords as $keyword) {
            if ($userTimeZoneHelper->getUserDate($keyword['last_update_date'], false) > $lastCheck) {
                $lastCheck = $keyword['last_update_date'];
            }
        }

        if ($lastCheck === false) {
            return;
        }

        $isSameDay = (date('Y-m-d', $lastCheck) === date('Y-m-d', $dateNow));

        if ($isSameDay) {
            return;
        }

        do_action('wprt_rank_daily_api_request');
    }
}
