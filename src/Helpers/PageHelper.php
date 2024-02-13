<?php

namespace WPRankTracker\Helpers;

class PageHelper
{
    public function isKeywordDetailPage()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $queryKeywordId = sanitize_text_field(wp_unslash($_GET['id'] ?? null));

        return $queryKeywordId !== '';
    }
    
    public function isKeywordPage() 
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return isset($_GET['page']) && $_GET['page'] === 'wp-rank-tracker';
    }

    public function getQueriedKeyword()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        return sanitize_text_field(wp_unslash($_GET['id'] ?? null));
    }
}
