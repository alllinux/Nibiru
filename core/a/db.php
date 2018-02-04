<?php
namespace Nibiru\Adapter;
use Nibiru\IDb;
use Nibiru\Pdo;

/**
 * Created by PhpStorm.
 * User: Stephan Kadsorf
 * Date: 26.01.18
 * Time: 17:24
 */

abstract class Db implements IDb
{
    private static $table = array();

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

    public function loadTableAsArray()
    {
        $result = Pdo::fetchTableAsArray( self::getTable()['table'] );
        return $result;
    }
    
    public function selectRowsetById($id = false)
    {
        // TODO: Implement selectRowsetById() method.
    }

    public function insertRowsetById($rowset = array(), $id = false)
    {
        // TODO: Implement insertRowsetById() method.
    }

    public function selectDatasetByMinMax($min = false, $max = false)
    {
        // TODO: Implement selectDatasetByMinMax() method.
    }

    public function insertArrayIntoTable($dataset = array())
    {
        // TODO: Implement insertArrayIntoTable() method.
    }

    public function nextInsertIndex()
    {
        // TODO: Implement nextInsertIndex() method.
    }

}