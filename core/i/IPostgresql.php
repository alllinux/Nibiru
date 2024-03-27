<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 08.12.17
 * Time: 11:56
 */

interface IPostgresql
{
    /**
     * @desc set the configuration section for the database to operate on
     * @param string $section
     * @return false
     */
    public static function settingsSection( $section = IOdbc::SETTINGS_DATABASE );

    /**
     * @desc returns the query by ressult
     * @param string $string
     *
     * @return array()
     */
    public static function query( $string = IPsql::PLACE_NO_QUERY );

    /**
     * @desc returns the row by id
     * @param bool $id
     *
     * @return array()
     */
    public static function fetchRowInArrayById( $tablename = IPsql::PLACE_TABLE_NAME, $id = IPsql::NO_ID );

    /**
     * @desc returns row by column name and search parameter
     * @param string $tablename
     * @param string $column_name
     * @param IMysql $
     * @return mixed
     */
    public static function fetchRowInArrayByWhere( $tablename = IPsql::PLACE_TABLE_NAME,
                                                   $column_name = IPsql::PLACE_COLUMN_NAME,
                                                   $parameter_name = IPsql::PLACE_SEARCH_TERM );

    /**
     * @desc will return the last inserted ID
     * @return integer
     */
    public static function getLastInsertedID();


    /**
     * @desc fetch all fieldnames of the parameter tablename to an array
     * @param string $tablename
     * @return mixed
     */
    public static function fetchTableFieldsAsArray( $tablename = IPsql::PLACE_TABLE_NAME );

    /**
     * @desc will return all entries from the selected tablename
     *
     * @param string $tablename
     *
     * @return mixed
     */
    public static function fetchTableAsArray( $tablename = IPsql::PLACE_TABLE_NAME );

    /**
     * @desc update field data by tablename and fieldname, filter by WHERE and AND
     * @param string $tablename
     * @param string $field_name
     * @param string $field_value
     * @param string $where_name
     * @param string $where_value
     * @param string $and_name
     * @param string $and_value
     * @return mixed
     */
    public static function updateFieldValueByWhere( $tablename = IPsql::PLACE_TABLE_NAME,
                                                    $field_name = IPsql::PLACE_FIELD_NAME,
                                                    $field_value = IPsql::PLACE_FIELD_VALUE,
                                                    $where_name = IPsql::PLACE_WHERE_NAME,
                                                    $where_value = IPsql::PLACE_WHERE_VALUE,
                                                    $and_name = IPsql::PLACE_AND_NAME,
                                                    $and_value = IPsql::PLACE_AND_VALUE );
    /**
     * @desc insert array content into database
     * @param string $tablename
     * @param string $array_name
     * @return mixed
     */
    public static function insertArrayIntoTable( $tablename = IPsql::PLACE_TABLE_NAME, $array_name = IPsql::PLACE_ARRAY_NAME, $encrypted = IPsql::PLACE_DES_ENCRYPT );

    /**
     * @desc truncate a table to zero entries
     * @param string $tablename
     * @return mixed
     */
    public static function truncateTable( $tablename = IPsql::PLACE_TABLE_NAME );
    
}