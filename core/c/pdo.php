<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 01.02.17
 * Time       - 18:55
 * @TODO      - SECURITY FIX REFACTORING NEEDED!
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
final class pdo extends Mysql implements IPdo
{
    private static $section = false;

    /**
     * @param string $section
     */
    public static function settingsSection( $section = IOdbc::SETTINGS_DATABASE )
    {
        self::$section = $section;
    }

    /**
     * @return bool
     */
    private static function getSettingsSection()
    {
        return self::$section;
    }

    /**
     * @desc Loads all table names from the current database.
     *
     * @security This method is protected and intended for use within the class hierarchy.
     *           It fetches the names of all tables in the database to facilitate validation
     *           of table names in database operations.
     *
     * @return array An array of table names.
     */
    protected static function loadTableNames(): array
    {
        try {
            $pdo = parent::getInstance(self::getSettingsSection())->getConn();
            $query = "SHOW TABLES";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            return $tables;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }


    /**
	 * @param string $string
	 *
	 * @return array|bool
	 */
    public static function query( $string = self::PLACE_NO_QUERY ): array|bool
    {

        if(!strstr($string, IOdbc::PLACE_SQL_UPDATE))
        {
            if(!strstr($string, IOdbc::PLACE_SQL_INSERT))
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
        }
        else
        {
            $query = parent::getInstance( self::getSettingsSection() )->getConn();
            return $query->exec($string);
        }
    }

    /**
     * @return array
     */
	private static function convertFetchToAssociative( array $result ): array
    {
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

    /**
     * @param string $string
     * @param bool $associative
     * @return array
     */
    public static function queryString( $string = self::PLACE_NO_QUERY, $associative = false )
    {
        $query = parent::getInstance( self::getSettingsSection() )->getConn()->query( $string );
        if(!$associative)
        {
            return $query->fetchAll();
        }
        else
        {
            return self::convertFetchToAssociative($query->fetchAll());
        }
    }

    /**
     * @param string $tablename
     * @param array $fieldAndValue
     * @param false $sortOrder
     * @return array
     */
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

        return self::convertFetchToAssociative($result->fetchAll());
    }

    /**
     * @param string $tablename
     * @param string $column_name
     * @param string $parameter_name
     * @param string $field_name
     * @param string $where_value
     * @return bool
     */
    public static function updateColumnByFieldWhere( $tablename = self::PLACE_TABLE_NAME,
                                                    $column_name = IMysql::PLACE_COLUMN_NAME,
                                                    $parameter_name = IMysql::PLACE_SEARCH_TERM,
                                                    $field_name = IMysql::PLACE_FIELD_NAME,
                                                    $where_value = IMysql::PLACE_WHERE_VALUE ): bool
    {
        $statement = parent::getInstance( self::getSettingsSection() )->getConn();
        $query = "UPDATE " . $tablename . " SET " . $column_name . " = :" . $column_name . " WHERE " . $field_name . " = :". $field_name;
        $insert = $statement->prepare($query);
        $insert->bindParam( ':'.$column_name, $parameter_name );
        $insert->bindParam( ':'.$field_name, $where_value );
        return $insert->execute();
    }

    /**
     * @desc Update a row in a database table by its primary key ID.
     *
     * @param string $tableName The name of the table to update.
     * @param array $data An associative array where keys are column names and values are the new values for those columns.
     * @param int $id The value of the primary key for the row to update.
     * @param string $encrypted The field that has encrypted data for handling correct field encryption
     *
     * @return bool Returns true on success or false on failure.
     */
    public static function updateRowById(string $tableName, array $columnNames, array $data, int $id, string $encrypted = IMysql::PLACE_DES_ENCRYPT): bool
    {
        try {
            // Inside a method of the mysql.db.php class or its subclass
            $validTables = self::loadTableNames();

            // Validate the table name
            if (!in_array($tableName, $validTables, true))
            {
                throw new \InvalidArgumentException("FATAL ERROR in main CORE updateRowById: Invalid table name: {$tableName}");
            }

            // Validate column names
            foreach (array_keys($data) as $column) {
                if (!in_array($column, $columnNames, true))
                {
                    throw new \InvalidArgumentException("FATAL ERROR in main CORE updateRowById: Invalid column name: {$column}");
                }
            }

            // Get PDO instance
            $pdo = parent::getInstance(self::getSettingsSection())->getConn();

            // Fetch the primary key field name
            $queryPrimaryKey = "SELECT COLUMN_NAME FROM information_schema.COLUMNS
                                WHERE TABLE_NAME = :tableName
                                AND COLUMN_KEY = 'PRI' LIMIT 1;";
            $stmtPrimaryKey = $pdo->prepare($queryPrimaryKey);
            $stmtPrimaryKey->bindValue(':tableName', $tableName);
            $stmtPrimaryKey->execute();
            $primaryKeyResult = $stmtPrimaryKey->fetch(\PDO::FETCH_ASSOC);

            if (!$primaryKeyResult)
            {
                throw new \RuntimeException('FATAL ERROR in main CORE updateRowById: No primary key found for table ' . $tableName);
            }
            $primaryKeyField = $primaryKeyResult['COLUMN_NAME'];
            $query = "UPDATE " . $tableName . " SET ";
            $updateParts = [];
            foreach ($data as $column => $value) {
                if ($column === $encrypted)
                {
                    // Encrypt the value using DES_ENCRYPT function
                    $updateParts[] = "$column = DES_ENCRYPT(:$column, :key)";
                } else {
                    $updateParts[] = "$column = :$column";
                }
            }
            $query .= implode(', ', $updateParts);
            $query .= " WHERE " . $primaryKeyField . " = :primaryKeyValue";
            $stmt = $pdo->prepare($query);
            foreach ($data as $column => $value) {
                $stmt->bindValue(':' . $column, $value);
            }
            if ($encrypted != "")
            {
                $key = Config::getInstance()->getConfig()[View::NIBIRU_SECURITY]["password_hash"];
                $stmt->bindValue(':key', $key);
            }
            $stmt->bindValue(':primaryKeyValue', $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @param string $tablename
     * @param bool $id
     * @return array
     */
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

    /**
     * @return int|string
     */
    public static function getLastInsertedID()
	{
		return parent::getInstance( self::getSettingsSection() )->getConn()->lastInsertId();
	}

    /**
     * @param string $tablename
     * @param string $limit
     * @param string $order
     * @return array|mixed
     */
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
     * @return bool
     */
	public static function insertArrayIntoTable( $tablename = IMysql::PLACE_TABLE_NAME, $array_name = IMysql::PLACE_ARRAY_NAME, $encrypted = IMysql::PLACE_DES_ENCRYPT ): bool
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
                    return $query->execute( $entry );
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
                return $query->execute( $array_name );
            }

        }
    }
}