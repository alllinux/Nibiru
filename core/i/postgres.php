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
interface IPostgres
{

	/**
	 * @desc returns the query by ressult
	 * @param string $string
	 *
	 * @return array()
	 */
	public static function query( $string = IOdbc::PLACE_NO_QUERY );

	/**
	 * @desc returns the row by id
	 * @param bool $id
	 *
	 * @return array()
	 */
	public static function fetchRowInArrayById( $tablename = IOdbc::PLACE_TABLE_NAME, $id = IOdbc::NO_ID );

    /**
     * @desc returns row by column name and search parameter
     * @param string $tablename
     * @param string $column_name
     * @param IMysql $
     * @return mixed
     */
	public static function fetchRowInArrayByWhere( $tablename = IOdbc::PLACE_TABLE_NAME,
                                                   $column_name = IOdbc::PLACE_COLUMN_NAME,
                                                   $parameter_name = IOdbc::PLACE_SEARCH_TERM );

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
	public static function fetchTableFieldsAsArray( $tablename = IOdbc::PLACE_TABLE_NAME );
	
	/**
	 * @desc will return all entries from the selected tablename
	 *
	 * @param string $tablename
	 *
	 * @return mixed
	 */
	public static function fetchTableAsArray( $tablename = IOdbc::PLACE_TABLE_NAME );

    /**
     * @desc insert array content into database
     * @param string $tablename
     * @param string $array_name
     * @return mixed
     */
	public static function insertArrayIntoTable( $tablename = IOdbc::PLACE_TABLE_NAME, $array_name = IOdbc::PLACE_ARRAY_NAME, $encrypted = IOdbc::PLACE_DES_ENCRYPT );
}