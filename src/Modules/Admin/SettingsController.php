<?php
namespace WPRankTracker\Modules\Admin;

use Exception;

class SettingsController
{
    /**
     * This method prepare to serve REST API endpoints to handle settings
     */
    public function __construct()
    {
        add_action( 'rest_api_init', [ $this, 'registerEndpoint' ] );
    }

    /**
     * Binds API endpoints
     *
     * @return void
     */
    public function registerEndpoint(): void
    {
        register_rest_route(
            'wprt/v1/api',
            '/save-settings',
            [
                [
                    'methods'  => 'POST',
                    'callback' => [
                        $this,
                        'saveSettings'
                    ],
                    'permission_callback' => function(\WP_REST_Request $request){
                        return current_user_can( 'manage_options' );
                    }
                 ]
             ]
        );
    }

    /**
     * This method saves the email to be notified.
     *
     * @param \WP_REST_Request $request
     * @return mixed
     */
    public function saveSettings( \WP_REST_Request $request ): mixed
    {
        $optionsHelper  = wprtContainer( 'OptionsHelper' );
        $responseHelper = wprtContainer( 'ResponseHelper' );

        try{

            $data      = json_decode( $request->get_body() );

            $email     = sanitize_email( $data->email );
            $frequency = sanitize_text_field( $data->frequency );
            $previousFrequency = $optionsHelper->getOption( 'notification_frequency' );

            if( is_null( $frequency ) ){
                return $responseHelper->sendJsonError(
                    __('Please enter a frequency', 'easy-rank-tracker'),
                    __('Frequency is required!', 'easy-rank-tracker')
                );
            }

            $optionsHelper->setOption( 'notification_email', $email );
            $optionsHelper->setOption( 'notification_frequency', $frequency );

            if( $previousFrequency !== $frequency ){
                do_action( 'wprt_reset_report_cron' );
            }

            return $responseHelper->sendJsonSuccess(
                __('Your settings have been saved', 'easy-rank-tracker'),
                __('Settings saved', 'easy-rank-tracker')
            );

        }catch(Exception $e){
            return $responseHelper->sendJsonError(
                $e->getMessage(),
                __('Error occured!', 'easy-rank-tracker')
            );
        }
    }
}
