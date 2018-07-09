<?php

namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 29.06.17
 * Time: 15:06
 */
class Postgres extends Odbc implements IPostgres
{
    /**
     * @desc does a plain SQL query on a postgres database, and returns the 
     *       result as an array
     * @param string $string
     * @return array
     */
    public static function query($string = IOdbc::PLACE_NO_QUERY)
    {
        $all = array();
        $result = \odbc_exec(parent::getInstance()->getConn(), $string);
        for($i=1;$row=\odbc_fetch_object($result,$i);$i++)
        {
            $row_values = array();
            $key_values = array();

            foreach($row as $key=>$item)
            {
                $row_values[] = $item;
                $key_values[] = $key;
            }
            $all[] = array_combine($key_values, $row_values);
        }
        return $all;
    }

    public static function fetchRowInArrayById($tablename = IOdbc::PLACE_TABLE_NAME, $id = IOdbc::NO_ID)
    {
        // TODO: Implement fetchRowInArrayById() method.
    }

    public static function fetchRowInArrayByWhere($tablename = IOdbc::PLACE_TABLE_NAME,
                                                  $column_name = IOdbc::PLACE_COLUMN_NAME,
                                                  $parameter_name = IOdbc::PLACE_SEARCH_TERM)
    {
        return self::query("SELECT * FROM " . $tablename . " WHERE " . $column_name . "='" . $parameter_name . "';");
    }

    public static function getLastInsertedID()
    {
        // TODO: Implement getLastInsertedID() method.
    }
    
    public static function fetchTableFieldsAsArray($tablename = IOdbc::PLACE_TABLE_NAME)
    {
        $columns = array();
        $result = \odbc_columns(parent::getInstance()->getConn(), null, null, $tablename);
        for($i=0;$row=\odbc_fetch_object($result, $i);$i++)
        {
            foreach ($row as $key=>$entry)
            {
                if(self::FILTER_COLUMN_NAME == $key)
                {
                    $columns[] = $entry;
                }
            }
        }
        return $columns;
    }
    
    public static function fetchTableAsArray($tablename = IOdbc::PLACE_TABLE_NAME)
    {
        return self::query("SELECT * FROM " . $tablename . ";");
    }

    public static function insertArrayIntoTable($tablename = IOdbc::PLACE_TABLE_NAME,
                                                $array_name = IOdbc::PLACE_ARRAY_NAME,
                                                $encrypted = IOdbc::PLACE_DES_ENCRYPT)
    {
        if(array_key_exists(0, $array_name))
        {
            foreach( $array_name as $entry )
            {
                $field_names = array_keys( $entry );
                $numItems = sizeof( $field_names );
                $i = 0;
                $row = " ( ";
                foreach( $field_names as $field )
                {
                    if( ++$i === $numItems )
                    {
                        $row .= $field;
                    }
                    else
                    {
                        $row .= $field . ", ";
                    }
                }
                $i = 0;
                $row .= " ) VALUES ( ";
                foreach ( $entry as $field )
                {
                    if( ++$i === $numItems )
                    {
                        $row .= "'" . $field . "'";
                    }
                    else
                    {
                        $row .= "'" . $field . "', ";
                    }
                }
                $row .= " )";
                $sql = 'INSERT INTO ' . $tablename . $row . ';';

                \odbc_exec(parent::getInstance()->getConn(), $sql);
            }
        }
        else
        {
            $field_names = array_keys($array_name);
            $numItems = sizeof($field_names);
            $i = 0;
            $row = " ( ";
            foreach( $field_names as $field )
            {
                if( ++$i === $numItems )
                {
                    $row .= $field;
                }
                else
                {
                    $row .= $field . ", ";
                }
            }
            $row .= " ) VALUES ( ";
            $i = 0;
            foreach ( $array_name as $entry )
            {
                if( ++$i === $numItems )
                {
                    $row .= "'" . $entry . "'";
                }
                else
                {
                    $row .= "'" . $entry . "', ";
                }
            }
            $row .= " )";
            $sql = 'INSERT INTO ' . $tablename . $row . ';';
            
            \odbc_exec(parent::getInstance()->getConn(), $sql);
        }
    }

    public static function truncateTable($tablename = IOdbc::PLACE_TABLE_NAME)
    {
        \odbc_exec(parent::getInstance( self::getSettingsSection() )->getConn(), "DELETE FROM " . $tablename . ";");
    }

}