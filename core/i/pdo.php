<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 19:03
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IPdo
{

	/**
	 * @desc returns the query by ressult
	 * @param string $string
	 *
	 * @return array()
	 */
	public static function query( $string = IMysql::PLACE_NO_QUERY );

	/**
	 * @desc returns the row by id
	 * @param bool $id
	 *
	 * @return array()
	 */
	public static function fetchRowInArrayById( $tablename = IMysql::PLACE_TABLE_NAME, $id = IMysql::NO_ID );

    /**
     * @desc returns row by column name and search parameter
     * @param string $tablename
     * @param string $column_name
     * @param IMysql $
     * @return mixed
     */
	public static function fetchRowInArrayByWhere( $tablename = IMysql::PLACE_TABLE_NAME,
                                                   $column_name = IMysql::PLACE_COLUMN_NAME,
                                                   $parameter_name = IMysql::PLACE_SEARCH_TERM );

	/**
	 * @desc will return the last inserted ID
	 * @return integer
	 */
	public static function getLastInsertedID();

	/**
	 * @desc will return all entries from the selected tablename
	 *
	 * @param string $tablename
	 *
	 * @return mixed
	 */
	public static function fetchTableAsArray( $tablename = IMysql::PLACE_TABLE_NAME );

    /**
     * @desc insert array content into database
     * @param string $tablename
     * @param string $array_name
     * @return mixed
     */
	public static function insertArrayIntoTable( $tablename = IMysql::PLACE_TABLE_NAME, $array_name = IMysql::PLACE_ARRAY_NAME, $encrypted = IMysql::PLACE_DES_ENCRYPT );
}