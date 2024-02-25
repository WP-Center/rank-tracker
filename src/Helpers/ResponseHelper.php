<?php

namespace WPRankTracker\Helpers;

class ResponseHelper
{
    /**
     * This method return error message.
     *
     * @param string $errorMessage Error message text.
     * @param string|null $variable Error message variable text.
     *
     * @return void
     */
    public function sendJsonError(string $errorMessage, string $variable = null, string $errorTitle = null): void
    {
        wp_send_json_error(
            [
                'message' => sprintf(__($errorMessage, 'easy-rank-tracker'), $variable),
                'title' => sprintf(__($errorTitle, 'easy-rank-tracker'), $variable),
            ]
        );
    }

    /**
     * This method return success message.
     *
     * @param string $successMessage Success message text.
     * @param string|null $variable Success message variable text.
     *
     * @return void
     */
    public function sendJsonSuccess(string $successMessage, string $variable = null, string $successTitle = null): void
    {
        wp_send_json_success(
            [
                'message' => sprintf(__($successMessage, 'easy-rank-tracker'), $variable),
                'title' => sprintf(__($successTitle, 'easy-rank-tracker'), $variable),
            ]
        );
    }

    /**
     * This method return success message.
     *
     * @param string $successMessage Success message text.
     * @param string $rank
     * @return void
     */
    public function sendJsonRankUpdate(string $successMessage, string $rank): void
    {
        wp_send_json_success(
            [
                'message' => __($successMessage, 'easy-rank-tracker'),
                'rank' => $rank,
            ]
        );
    }

    /**
     * This method return success message.
     *
     * @param string $successMessage Success message text.
     * @param string $warningMessage
     * @return void
     */
    public function sendJsonWarning(string $successMessage, string $warningMessage): void
    {
        wp_send_json_success(
            [
                'message' => __($successMessage, 'easy-rank-tracker'),
                'warning' => __($warningMessage, 'easy-rank-tracker'),
            ]
        );
    }
}
