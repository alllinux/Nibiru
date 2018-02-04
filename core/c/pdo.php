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

	/**
	 * @param string $string
	 *
	 * @return array
	 */
	public static function query( $string = self::PLACE_NO_QUERY )
	{
		$query = parent::getInstance()->getConn()->query( $string );
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

	public static function fetchRowInArrayById($tablename = self::PLACE_TABLE_NAME, $id = self::NO_ID )
	{
        $result = array();
	    $statement = parent::getInstance()->getConn();
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
        $prepare->execute($id);
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

    public static function fetchRowInArrayByWhere($tablename = IMysql::PLACE_TABLE_NAME,
                                                  $column_name = IMysql::PLACE_COLUMN_NAME,
                                                  $parameter_name = IMysql::PLACE_SEARCH_TERM)
    {
        $statement = parent::getInstance()->getConn();
        $prepare = $statement->prepare("SELECT * FROM " . $tablename . " WHERE " . $column_name . " = :" . $parameter_name . ";");
        $prepare->execute();
        $rowset = array_shift($prepare->fetchAll());

        foreach(array_keys($rowset) as $entry)
        {
            if(is_string($entry))
            {
                $result[$entry] = $rowset[$entry];
            }
        }
        return $result;
    }

    public static function getLastInsertedID()
	{
		// TODO: Implement getLastInsertedID() method.
	}

	public static function fetchTableAsArray( $tablename = self::PLACE_TABLE_NAME )
	{
		$statement = parent::getInstance()->getConn()->query('SElECT * FROM ' . $tablename);
		$statement->execute();
		$result = $statement->fetchAll( \PDO::FETCH_ASSOC );
		return $result;
	}

	public static function insertArrayIntoTable( $tablename = IMysql::PLACE_TABLE_NAME, $array_name = IMysql::PLACE_ARRAY_NAME, $encrypted = IMysql::PLACE_DES_ENCRYPT )
    {
        $statement = parent::getInstance()->getConn();

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
                            $row .= ":" . $field ;
                        }
                        else
                        {
                            $row .= ":" . $field . ", ";
                        }
                    }
                    $row .= " )";
                    $query = $statement->prepare('INSERT INTO ' . $tablename . $row);
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
                        $row .= ":" . $field ;
                    }
                    else
                    {
                        $row .= ":" . $field . ", ";
                    }
                }
                $row .= " )";
                $query = $statement->prepare('INSERT INTO ' . $tablename . $row);
                $query->execute( $array_name );
            }

        }
    }
}