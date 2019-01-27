<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 08.12.17
 * Time: 11:52
 */

class Postgresql extends Psql implements IPostgresql
{
    private static $section = false;

    public static function settingsSection( $section = IOdbc::SETTINGS_DATABASE )
    {
        self::$section = $section;
    }

    private static function getSettingsSection()
    {
        return self::$section;
    }

    /**
     * @desc does a plain SQL query on a postgres database, and returns the
     *       result as an array
     * @param string $string
     * @return array
     */
    public static function query($string = IPsql::PLACE_NO_QUERY)
    {
        $all = array();
        $result = \pg_query(parent::getInstance( self::getSettingsSection() )->getConn(), $string);
        while($row=\pg_fetch_object($result))
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

    public static function fetchRowInArrayById($tablename = IPsql::PLACE_TABLE_NAME, $id = IPsql::NO_ID)
    {
        // TODO: Implement fetchRowInArrayById() method.
    }

    public static function fetchRowInArrayByWhere($tablename = IPsql::PLACE_TABLE_NAME,
                                                  $column_name = IPsql::PLACE_COLUMN_NAME,
                                                  $parameter_name = IPsql::PLACE_SEARCH_TERM)
    {
        return self::query("SELECT * FROM " . $tablename . " WHERE " . $column_name . "='" . $parameter_name . "';");
    }

    public static function getLastInsertedID()
    {
        // TODO: Implement getLastInsertedID() method.
    }

    public static function fetchTableFieldsAsArray($tablename = IPsql::PLACE_TABLE_NAME)
    {
        $columns = array();
        $sqlFieldNames = "SELECT column_name FROM information_schema.columns WHERE table_schema = 'public' AND table_name = '" . $tablename . "';";
        $result = \pg_query($sqlFieldNames);
        $result = \pg_fetch_all_columns($result, 1);
        for($i=0;$row=\pg_fetch_object($result, $i);$i++)
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

    public static function fetchTableAsArray($tablename = IPsql::PLACE_TABLE_NAME)
    {
        return self::query("SELECT * FROM " . $tablename . ";");
    }

    public static function updateFieldValueByWhere( $tablename = IPsql::PLACE_TABLE_NAME,
                                                    $field_name = IPsql::PLACE_FIELD_NAME,
                                                    $field_value = IPsql::PLACE_FIELD_VALUE,
                                                    $where_name = IPsql::PLACE_WHERE_NAME,
                                                    $where_value = IPsql::PLACE_WHERE_VALUE,
                                                    $and_name = IPsql::PLACE_AND_NAME,
                                                    $and_value = IPsql::PLACE_AND_VALUE )
    {
        if(is_string($field_name))
        {
            if($and_name!=IPsql::PLACE_AND_NAME)
            {
                $sql_prepare = 'UPDATE ' . $tablename . ' SET ' . $field_name . '=? WHERE ' . $where_name . '=? AND ' . $and_name . '=?;';
                $res = \pg_prepare(parent::getInstance( self::getSettingsSection() )->getConn(), "", $sql_prepare);
                \pg_execute($res, "", array($field_value, $where_value, $and_value));
            }
            else
            {
                $sql_prepare = 'UPDATE ' . $tablename . ' SET ' . $field_name . '=? WHERE ' . $where_name .'=?;';
                $res = \pg_prepare(parent::getInstance( self::getSettingsSection() )->getConn(),"", $sql_prepare);
                \pg_execute($res, "", array($field_value, $where_value));
            }
            unset($sql_prepare);
            $res = NULL;
        }
    }

    public static function insertArrayIntoTable($tablename = IPsql::PLACE_TABLE_NAME,
                                                $array_name = IPsql::PLACE_ARRAY_NAME,
                                                $encrypted = IPsql::PLACE_DES_ENCRYPT)
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
                \pg_exec(parent::getInstance( self::getSettingsSection() )->getConn(), $sql);
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

            \pg_exec(parent::getInstance( self::getSettingsSection() )->getConn(), $sql);
        }
    }

    public static function truncateTable($tablename = IPsql::PLACE_TABLE_NAME)
    {
        \pg_exec(parent::getInstance( self::getSettingsSection() )->getConn(), "DELETE FROM " . $tablename . ";");
    }

}