<?php

namespace WPRankTracker\Modules\Ranks;

use Illuminate\Container\Container;

class RankDatabaseController extends Container
{
    /**
     * @var string Database table name.
     */
    public string $tableName = 'ranks';

    /**
     * This method plugin activated send function.
     */
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'createTable']);
    }

    /**
     * This method create wp_wprt_ranks table.
     *
     * @return void
     */
    public function createTable(): void
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $charsetCollate = $databaseHelper->getCharset();
        $rankTable = $databaseHelper->getPrefix() . $this->tableName;

        if ($databaseHelper->isTableExist($rankTable)) {
            $sql = "CREATE TABLE $rankTable (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            keyword_id varchar(100) DEFAULT '' NOT NULL,
            ranks LONGTEXT DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
            )$charsetCollate;";

            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
}
