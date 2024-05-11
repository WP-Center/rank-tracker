<?php

namespace WPRankTracker\Modules\Admin;

class NotificationController
{
    /**
     * This method prepare to serve a REST API request.
     */
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'registerEndpoint']);
    }

    /**
     * @return void
     */
    public function registerEndpoint(): void
    {
        register_rest_route(
            'wprt/v1/api',
            '/save-email',
            [
                [
                    'methods' => 'POST',
                    'callback' => [
                        $this,
                        'saveEmail',
                    ],
                ],
            ]
        );
    }

    /**
     * This method saves the email to be notified.
     *
     * @param \WP_REST_Request $request
     *
     * @return void
     */
    public function saveEmail(\WP_REST_Request $request)
    {
        $activationHelper = wprtContainer('ResponseHelper');
        $optionsHelper = wprtContainer('OptionsHelper');

        $request = json_decode($request->get_body());
        $email = sanitize_text_field($request->email);

        if (is_null($email)) {
            return $activationHelper->sendJsonError(__('Please enter an E-mail', 'easy-rank-tracker'));
        }

        $optionsHelper->setOption('notification_email', $email ?? '');
    }

    public function sendRankChangeEmail($keywordId, $oldRank, $newRank)
    {
        $keywordController = wprtContainer('GetKeywordsController');
        $keywordData = $keywordController->getKeywordById($keywordId);
        $adminEmail = !empty(get_option('notification_email')) ? get_option('notification_email') : get_option('admin_email');

        $subject = __('Keyword Rank Update: ', 'easy-rank-tracker') . $keywordData->keyword;

        if ($newRank < $oldRank) {
            $messageBody = __("Congratulations, your keyword's rank has improved!", 'easy-rank-tracker');
        } else {
            $messageBody = __("Sorry, your keyword's rank has decreased.", 'easy-rank-tracker');
        }

        $message = "
            <html>
            <head>
            <title>{$subject}</title>
            </head>
            <body>
            <h2>{$subject}</h2>
  <p>{$messageBody}</p>
  <p><strong>" . __('Keyword:', 'easy-rank-tracker') . "</strong> {$keywordData->keyword}</p>
  <p><strong>" . __('Old Rank:', 'easy-rank-tracker') . "</strong> {$oldRank}</p>
  <p><strong>" . __('New Rank:', 'easy-rank-tracker') . "</strong> {$newRank}</p>
  <hr>
  <p>" . __('This is an automated notification message and is not monitored.', 'easy-rank-tracker') . "</p>
  <p>" . __('Best Regards,', 'easy-rank-tracker') . "<br> " . __('Your Rank Tracker Team', 'easy-rank-tracker') . "</p>
</body>
</html>
";
        wp_mail($adminEmail, $subject, $message);
    }
}
