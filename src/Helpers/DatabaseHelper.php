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

        $table_name = $this->getPrefix() . $tableName;

        $query = "SELECT $columns FROM $table_name";

        $placeholders = [];
        if ($parameters) {
            $where_clause = join(' AND ', array_map(
                fn($key) =>
                "`$key` = %s",
                array_keys($parameters)
            ));
            $query .= " WHERE $where_clause";

            $placeholders = array_merge($placeholders, array_values($parameters));
        }

        if ($orderBy) {
            $order_clause = join(', ', array_map(
                fn($key, $value) => "$key $value",
                array_keys($orderBy),
                $orderBy
            ));
            $query .= " ORDER BY $order_clause";
        }

        if ($limit) {
            $query .= " LIMIT $limit";
        }

        $prepare = $query;
        
        if ($placeholders) {
            $prepare = $wpdb->prepare($query, $placeholders);
        }

        return $wpdb->get_results($prepare);
    }

    public function truncateTable(string $tableName): void
    {
        global $wpdb;

        $tableName = $this->getPrefix() . $tableName;
        
        $wpdb->query($wpdb->prepare("TRUNCATE TABLE %s", $tableName));
    }
}
