<?php

namespace WPRankTracker\Helpers;

use Illuminate\Container\Container;

class DatabaseHelper extends Container
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        global $wpdb;

        return $wpdb->prefix . WPRT_PREFIX;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        global $wpdb;

        return $wpdb->get_charset_collate();
    }

    /**
     * This method check is table exist or nor
     *
     * @param string $tableName Database table name.
     *
     * @return boolean
     */
    public function isTableExist(string $tableName): bool
    {
        global $wpdb;

        return ($wpdb->get_var($wpdb->prepare("show tables like %s", $tableName)) != $tableName);
    }

    /**
     * @param string $tableName Database table name.
     * @param array $data Keyword id number.
     *
     * @return int
     */
    public function addData(string $tableName, array $data): int
    {
        global $wpdb;
        $tableName = $this->getPrefix() . $tableName;
        $wpdb->insert($tableName, $data);

        return $wpdb->insert_id;
    }

    /**
     * @param string $tableName Database table name.
     * @param array $data Keyword id number.
     * @param array $where Keyword id number.
     *
     * @return void
     */
    public function updateData(string $tableName, array $data, array $where): void
    {
        global $wpdb;
        $wpdb->update(
            $this->getPrefix() . $tableName,
            $data,
            $where
        );
    }

    /**
     * @param string $tableName Database table name.
     * @param array $data Keyword id number.
     *
     * @return void
     */
    public function deleteData(string $tableName, array $data): void
    {
        global $wpdb;
        $wpdb->delete(
            $this->getPrefix() . $tableName,
            $data
        );
    }

    /**
     * @param string $tableName Database table name.
     * @param array|null $parameters Keywords array.
     * @param array|null $orderBy OrderBy array.
     * @param string $columns Select Columns
     * @return array|null
     */
    public function getRow(
        string $tableName,
        array $parameters = null,
        array $orderBy = null,
        string $columns = '*',
        ?int $limit = null
    ): ?array {

        global $wpdb;

        if ($tableName === 'keywords') {
            $query = "SELECT * FROM {$wpdb->prefix}wprt_keywords";
        } else {
            $query = "SELECT * FROM {$wpdb->prefix}wprt_ranks";
        }

        if ($parameters) {
            $counter = 0;
            foreach ($parameters as $key => $value) {
                if ($counter === 0) {
                    // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
                    $query .= $wpdb->prepare(" WHERE `%1s` = %s", $key, $value);
                } else {
                    // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
                    $query .= $wpdb->prepare(" AND `%1s` = %s", $key, $value);
                }

                $counter++;
            }
        }

        if ($orderBy) {
            foreach ($orderBy as $key => $value) {
                // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
                $query .= $wpdb->prepare(" ORDER BY `%1s` %s", $key, $value);
            }
        }

        if ($limit) {
            // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
            $query .= $wpdb->prepare(" LIMIT %1s", $limit);
        }

        /**
         * Ignored unprepared because it is already dynamic query that is already prepared in each step
         * Ref: https://github.com/WordPress/WordPress-Coding-Standards/issues/508
         */
        return $wpdb->get_results($query); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    }

    public function truncateTable(string $tableName): void
    {
        global $wpdb;

        $tableName = $this->getPrefix() . $tableName;

        $wpdb->query($wpdb->prepare("TRUNCATE TABLE %s", $tableName));
    }
}
