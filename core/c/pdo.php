<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 18:55
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
final class Pdo extends Mysql implements IPdo
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
	 * @param string $string
	 *
	 * @return array
	 */
	public static function query( $string = self::PLACE_NO_QUERY )
	{
		$query = parent::getInstance( self::getSettingsSection() )->getConn()->query( $string );
		while($row = $query->fetch())
		{
			$keys = array_keys($row);
			for($i=0;sizeof($keys)>$i;$i += 2)
			{
				$row_values[] = $row[$keys[$i]];
				$key_values[] = $keys[$i];
			}
			$result = array_combine($key_values, $row_values);
		}

		return $result;
	}

    /**
     * @param string $string
     *
     * @return array
     */
    public static function queryString( $string = self::PLACE_NO_QUERY )
    {
        $query = parent::getInstance( self::getSettingsSection() )->getConn()->query( $string );
        return $query->fetchAll();
    }

    public static function selectDatasetByFieldAndValue($tablename = self::PLACE_TABLE_NAME, $fieldAndValue = array(), $sortOrder = false )
    {
        if(is_array($sortOrder))
        {
            $result = parent::getInstance( self::getSettingsSection() )->getConn()->query("SELECT * FROM " . $tablename . " WHERE " . $fieldAndValue['name'] . " = '" . $fieldAndValue['value'] . " ORDER BY ".$sortOrder['field']." ". $sortOrder['order'] ."';");
        }
        else
        {
            $result = parent::getInstance( self::getSettingsSection() )->getConn()->query("SELECT * FROM " . $tablename . " WHERE " . $fieldAndValue['name'] . " = '" . $fieldAndValue['value'] . "';");
        }

        $result = $result->fetchAll();
        $resultset = [];
        if(array_key_exists(0, $result))
        {
            foreach($result as $rowset)
            {
                $set = [];
                foreach($rowset as $key=>$row)
                {
                    if(!is_numeric($key))
                    {
                        $set[$key] = $row;
                    }
                }
                $resultset[] = $set;
            }
        }
        else
        {
            foreach($result as $key=>$row)
            {
                if(!is_numeric($row))
                {
                    $resultset[$key] = $row;
                }
            }
        }

        return $resultset;
    }

    public static function updateColumnByFieldWhere( $tablename = self::PLACE_TABLE_NAME,
                                                    $column_name = IMysql::PLACE_COLUMN_NAME,
                                                    $parameter_name = IMysql::PLACE_SEARCH_TERM,
                                                    $field_name = IMysql::PLACE_FIELD_NAME,
                                                    $where_value = IMysql::PLACE_WHERE_VALUE )
    {
        $statement = parent::getInstance( self::getSettingsSection() )->getConn();
        $query = "UPDATE " . $tablename . " SET " . $column_name . " = :" . $column_name . " WHERE " . $field_name . " = :". $field_name;
        $insert = $statement->prepare($query);
        $insert->bindParam( ':'.$column_name, $parameter_name );
        $insert->bindParam( ':'.$field_name, $where_value );
        $insert->execute();
    }

	public static function fetchRowInArrayById($tablename = self::PLACE_TABLE_NAME, $id = self::NO_ID )
	{
        $result = array();
	    $statement = parent::getInstance( self::getSettingsSection() )->getConn();
	    $describe = $statement->query('DESC ' . $tablename);
	    $describe->execute();
        $tableInformation = $describe->fetchAll( \PDO::FETCH_ASSOC );
        foreach ( $tableInformation as $entry )
        {
            if( $entry["Key"] == IMysql::PLACE_PRIMARY_KEY )
            {
                $id_name = $entry["Field"];
            }
        }
        $prepare = $statement->prepare("SELECT * FROM " . $tablename . " WHERE " . $id_name . " = :" . $id_name . ";");
        $prepare->bindParam(":".$id_name, $id, \PDO::PARAM_INT);
        $prepare->execute();
        $fetchAll = $prepare->fetchAll();
        $rowset = array_shift($fetchAll);

        foreach(array_keys($rowset) as $entry)
        {
            if(is_string($entry))
            {
                $result[$entry] = $rowset[$entry];
            }
        }
        return $result;
    }

    /**
     * @desc selects the given table row by given parameter and column
     * @param string $tablename
     * @param string $column_name
     * @param string $parameter_name
     * @return mixed
     */
    public static function fetchRowInArrayByWhere($tablename = IMysql::PLACE_TABLE_NAME,
                                                  $column_name = IMysql::PLACE_COLUMN_NAME,
                                                  $parameter_name = IMysql::PLACE_SEARCH_TERM)
    {
        $statement = parent::getInstance( self::getSettingsSection() )->getConn();
        $prepare = $statement->prepare("SELECT * FROM " . $tablename . " WHERE " . $column_name . " = :" . $column_name . ";");
        $prepare->bindParam(":".$column_name, $parameter_name, \PDO::PARAM_STR);
        $prepare->execute();
        $r = $prepare->fetchAll();
        $rowset = array_shift( $r );
        try{
            if(is_array($rowset))
            {
                if(sizeof($rowset)>0)
                {
                    foreach(array_keys($rowset) as $entry)
                    {
                        if(is_string($entry))
                        {
                            $result[$entry] = $rowset[$entry];
                        }
                    }
                    return $result;
                }
            }
            else
            {
                return false;
            }
        }
        catch (\Exception $e)
        {
            echo '<pre>';
            print_r($e);
            echo '</pre>';
            die();
        }
    }

    /**
     * @desc selects the given table row by given parameter and column
     * @param string $tablename
     * @param string $column_name
     * @param string $parameter_name
     * @return mixed
     */
    public static function fetchRowsInArrayByWhere($tablename = IMysql::PLACE_TABLE_NAME,
                                                   $column_name = IMysql::PLACE_COLUMN_NAME,
                                                   $parameter_name = IMysql::PLACE_SEARCH_TERM)
    {
        $statement = parent::getInstance( self::getSettingsSection() )->getConn();
        $result = [];
        $prepare = $statement->prepare("SELECT * FROM " . $tablename . " WHERE " . $column_name . " = :" . $column_name . ";");
        $prepare->bindParam(":".$column_name, $parameter_name, \PDO::PARAM_STR);
        $prepare->execute();
        $r = $prepare->fetchAll();
        foreach($r as $key=>$item)
        {
            foreach ($item as $index=>$field)
            {
                if(!is_numeric($index))
                {
                    $result[$key][$index] = $field;
                }
            }
        }
        return $result;
    }

    public static function getLastInsertedID()
	{
		return parent::getInstance( self::getSettingsSection() )->getConn()->lastInsertId();
	}

    public static function fetchTableAsArray( $tablename = self::PLACE_TABLE_NAME, $limit = self::PLACE_QUERY_LIMIT, $order = self::PLACE_SORT_ORDER )
    {
        if($limit != self::PLACE_QUERY_LIMIT)
        {
            if( $order == self::PLACE_SORT_ORDER )
            {
                $order = "";
            }
            if(is_array($limit))
            {
                if(array_key_exists('start', $limit))
                {
                    $statement = parent::getInstance( self::getSettingsSection() )->getConn()->query('SELECT * FROM ' . $tablename . $order . ' LIMIT ' . $limit['start'] . ', ' . $limit['end'] . ';' );
                }
            }
            else
            {
                $statement = parent::getInstance( self::getSettingsSection() )->getConn()->query('SElECT * FROM ' . $tablename . $order . ' LIMIT ' . $limit . ';');
            }
        }
        else
        {
            $statement = parent::getInstance( self::getSettingsSection() )->getConn()->query('SElECT * FROM ' . $tablename);
        }
        $statement->execute();
        $result = $statement->fetchAll( \PDO::FETCH_ASSOC );
        return $result;
    }

    /**
     * @desc will insert the array with fieldnames into the database, if the last parameter is set it should be a string containing the
     *       fieldname that should be encrypted
     * @param string $tablename
     * @param string $array_name
     * @param bool $encrypted
     */
	public static function insertArrayIntoTable( $tablename = IMysql::PLACE_TABLE_NAME, $array_name = IMysql::PLACE_ARRAY_NAME, $encrypted = IMysql::PLACE_DES_ENCRYPT )
    {
        $statement = parent::getInstance( self::getSettingsSection() )->getConn();

        if(is_array($array_name))
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
                    foreach ( $field_names as $field )
                    {
                        if( ++$i === $numItems )
                        {
                            if($field == $encrypted)
                            {
                                $row .= "DES_ENCRYPT(:".$encrypted.", :key)";
                            }
                            else
                            {
                                $row .= ":" . $field ;
                            }
                        }
                        else
                        {
                            if($field == $encrypted)
                            {
                                $row .= "DES_ENCRYPT(:".$encrypted.", :key), ";
                            }
                            else
                            {
                                $row .= ":" . $field . ", ";
                            }
                        }
                    }
                    $row .= " )";
                    $query = $statement->prepare('INSERT INTO ' . $tablename . $row);
                    if($encrypted)
                    {
                        $array_name['key'] = Config::getInstance()->getConfig()[View::NIBIRU_SECURITY]["password_hash"];
                    }
                    $query->execute( $entry );
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
                foreach ( $field_names as $field )
                {
                    if( ++$i === $numItems )
                    {
                        if($field == $encrypted)
                        {
                            $row .= "DES_ENCRYPT(:".$encrypted.", :key)";
                        }
                        else
                        {
                            $row .= ":" . $field ;
                        }
                    }
                    else
                    {
                        if($field == $encrypted)
                        {
                            $row .= "DES_ENCRYPT(:".$encrypted.", :key), ";
                        }
                        else
                        {
                            $row .= ":" . $field . ", ";
                        }
                    }
                }
                $row .= " )";
                $query = $statement->prepare('INSERT INTO ' . $tablename . $row);
                if($encrypted)
                {
                    $array_name['key'] = Config::getInstance()->getConfig()[View::NIBIRU_SECURITY]["password_hash"];
                }
                $query->execute( $array_name );
            }

        }
    }
}