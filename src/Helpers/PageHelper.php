<?php

namespace WPRankTracker\Helpers;

use Illuminate\Container\Container;

class PageHelper extends Container
{
    public function isKeywordDetailPage()
    {
        $queryKeywordId = sanitize_text_field(wp_unslash($_GET['id'] ?? null));

        return $queryKeywordId !== '';
    }
    
    public function isKeywordPage() 
    {
        return isset($_GET['page']) && $_GET['page'] === 'wp-rank-tracker';
    }

    public function getQueriedKeyword()
    {
        return sanitize_text_field(wp_unslash($_GET['id'] ?? null));
    }
}
