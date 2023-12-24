<?php

namespace WPRankTracker\Modules\Keywords;

use Illuminate\Container\Container;

class KeywordDatabaseController extends Container
{
    /**
     * @var string Database table name.
     */
    public string $tableName = 'keywords';

    /**
     * This method plugin activated send function.
     */
    public function __construct()
    {
        add_action('wprt_activation', [$this, 'createTable']);
    }

    /**
     * This method create wp_wprt_keywords table.
     *
     * @return void
     */
    public function createTable(): void
    {
        $databaseHelper = wprtContainer('DatabaseHelper');
        $charsetCollate = $databaseHelper->getCharset();
        $tableName = $databaseHelper->getPrefix() . $this->tableName;

        if ($databaseHelper->isTableExist($tableName)) {
            $sql = "CREATE TABLE $tableName (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            keyword varchar(255) DEFAULT '' NOT NULL,
            country varchar(55) DEFAULT '' NOT NULL,
            last_update_date varchar(255) DEFAULT '' NOT NULL,
            PRIMARY KEY  (id)
            )$charsetCollate;";

            include_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
}
