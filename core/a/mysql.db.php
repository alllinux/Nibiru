<?php
namespace Nibiru\Adapter\MySQL;

use Nibiru\Pdo;
use Nibiru\Factory;
use Nibiru\Adapter\IDb;

/**
 * Created by PhpStorm.
 * User: Stephan Kadsorf
 * Date: 26.01.18
 * Time: 17:24
 */

abstract class Db implements IDb
{
    private static $table = array();

    /**
     * @param array $table
     */
    protected static function initTable( $table = array() )
    {
        self::setTable( $table );
    }

    /**
     * @return array
     */
    protected static function getTable()
    {
        return self::$table;
    }

    /**
     * @param array $table
     */
    private static function setTable( $table = array() )
    {
        if( sizeof($table)>0 )
        {
            self::$table = $table;
        }
    }

    /**
     * @param bool $user_name
     * @return mixed
     */
    public function loadPasswordByUsername( $user_name = false )
    {
        $result = Pdo::query("SELECT DES_DECRYPT(".self::TABLE['field']['user_pass'].", '" . Config::getInstance()->getConfig()[View::NIBIRU_SECURITY]["password_hash"] . "') AS ".self::TABLE['field']['user_pass']." FROM user WHERE " . self::TABLE['field']['user_name']. " = '" . $user_name . "';");
        return array_shift($result);
    }

    /**
     * @return mixed
     */
    public function loadTableAsArray()
    {
        $result = Pdo::fetchTableAsArray( self::getTable()['table'] );
        return $result;
    }

    /**
     * @param bool $id
     * @return mixed|void
     */
    public function selectRowsetById($id = false)
    {
        return Pdo::fetchRowInArrayById( self::getTable()['table'], $id );
    }

    /**
     * @param array $rowset
     * @param bool $id
     * @return mixed|void
     */
    public function insertRowsetById($rowset = array(), $id = false)
    {
        // TODO: Implement insertRowsetById() method.
    }

    /**
     * @param bool $min
     * @param bool $max
     * @return mixed|void
     */
    public function selectDatasetByMinMax($min = false, $max = false)
    {
        // TODO: Implement selectDatasetByMinMax() method.
    }

    /**
     * @desc inserts an array into the database as on of the fields may be encrypted, but it has to be a varbinary field 
     * @param array $dataset
     * @param bool $encrypted
     */
    public function insertArrayIntoTable($dataset = array(), $encrypted = false)
    {
        if($encrypted)
        {
            Pdo::insertArrayIntoTable(self::$table['table'], $dataset, $encrypted);
        }
        else
        {
            Pdo::insertArrayIntoTable(self::$table['table'], $dataset);
        }
    }

    public function nextInsertIndex()
    {
        // TODO: Implement nextInsertIndex() method.
    }

    /**
     * @desc updates a row by a given field and field where search value
     * @param bool $wherefield
     * @param bool $wherevalue
     * @param bool $rowfield
     * @param bool $rowvalue
     */
    public function updateRowByFieldWhere( $wherefield = false, $wherevalue = false, $rowfield = false, $rowvalue = false )
    {
        Pdo::updateColumnByFieldWhere( self::$table['table'], $rowfield, $rowvalue, $wherefield, $wherevalue );
    }

    /**
     * @desc select a row by the selected fieldset ( field and where value )
     * @param array $field
     * @return mixed
     */
    public function selectRowByFieldWhere( $field = array() )
    {
        return Pdo::fetchRowInArrayByWhere(self::$table['table'], $field['field'], $field['value']);
    }


}