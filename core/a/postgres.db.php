<?php

namespace Nibiru\Adapter\Postgres;

use Nibiru\Postgres;
use Nibiru\Factory;
use Nibiru\Adapter\IDb;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 17.01.18
 * Time: 09:01
 */
abstract class Db implements IDb
{

    /**
     * @desc class parameters
     */
    private static $table = array();
    private $_multithreatCount = 0;
    private $_nextIndex = NULL;

    /**
     * @desc load the table array from the model in order to have the correct fields and the correct table name
     * @param array $tableArray
     */
    protected static function initTable( $tableArray = array() )
    {
        self::setTable( $tableArray );
    }

    /**
     * @desc getter for the table constant array
     * @return array
     */
    private static function getTable(): array
    {
        return self::$table;
    }

    /**
     * @desc setter for the table constant array
     * @param array $table
     */
    private static function setTable( $table )
    {
        self::$table = $table;
    }

    /**
     * @desc Selects a rowset by the dataset id
     * @param bool $id
     * @return array|mixed
     * @throws \Exception
     */
    public function selectRowsetById($id = false)
    {
        try
        {
            return Postgres::query("SELECT * FROM " . self::getTable()['table'] . " WHERE " . self::getTable()['fields']['id'] . " = " . $id . ";" );
        }
        catch (\Exception $e)
        {
            throw new \Exception(print_r($e, true));
        }
    }

    /**
     * @desc Selects a columnlist by a given field array from the current selected table
     * @param array $fieldarray
     * @return array
     * @throws \Exception
     */
    public function selectColumnByFieldArray( $fieldarray = array() )
    {
        try
        {
            $numItems = count($fieldarray);
            $i=0;
            $fields = "";
            foreach($fieldarray as $key=>$field)
            {
                if(++$i === $numItems)
                {
                    $fields .= $field . " ";
                }
                else
                {
                    $fields .= $field . ", ";
                }
            }
            return Postgres::query("SELECT " . $fields . "FROM " . self::getTable()['table'] . ";");
        }
        catch(\Exception $e)
        {
            throw new \Exception(print_r($e, true));
        }

    }

    public function insertRowsetById($rowset = array(), $id = false)
    {
        // TODO: Implement insertRowsetById() method.
    }

    /**
     * @desc Selects a Field by max value, or multiple fields by max value, same with min fields.
     *       Both can be combined.
     * @param string|array $min
     * @param string|array $max
     * @return array|mixed
     */
    public function selectDatasetByMinMax($min = false, $max = false)
    {
        if($min)
        {
            $fields = "";
            if(is_array($min))
            {
                $numItems = count($min);
                $i = 0;
                foreach ($min as $key=>$item)
                {
                    if(++$i === $numItems)
                    {
                        $fields .= "MIN(" . $item .") as min_" .$item . " ";
                    }
                    else
                    {
                        $fields .= "MIN(" . $item .") as min_".$item.", ";
                    }
                }
            }
            else
            {
                $fields .= "MIN(".$min.") as min_" . $min . " ";
            }
        }
        if($max)
        {
            $mfields = "";
            if(is_array($max))
            {
                $numItems = count($max);
                $y = 0;
                foreach ($max as $key=>$item)
                {
                    if(++$y === $numItems)
                    {
                        $mfields .= "MAX(" . $item .") as max_" .$item . " ";
                    }
                    else
                    {
                        $mfields .= "MAX(" . $item .") as max_".$item.", ";
                    }
                }
            }
            else
            {
                $mfields .= "MAX(".$max.") as max_" . $max . " ";
            }
        }
        if(!empty($fields))
        {
            if(!empty($mfields))
            {
                $result = Postgres::query("SELECT " . $fields . ", " . $mfields . " FROM " . self::getTable()['table']);
            }
            else
            {
                $result = Postgres::query("SELECT " . $fields . " FROM " . self::getTable()['table']);
            }
        }

        if(!empty($mfields) && empty($fields))
        {
            $result = Postgres::query("SELECT " . $mfields . " FROM " . self::getTable()['table']);
        }
        return $result;
    }

    /**
     * @desc Gets the next dataset ID for insertation, if the dataset should be iterated and not be related to the last insert id because that one is already
     *       present it can also be iterated
     * @param bool $iterate
     * @return int|mixed|null
     */
    public function nextInsertIndex($iterate = false)
    {
        if(!$iterate)
        {
            $cur = array_shift(Postgres::query('SELECT MAX(id) AS id FROM ' . self::getTable()['table'] . ';'));
            if(empty(array_filter($cur)))
            {
                $cur["id"] = 1;
            }
            else
            {
                $cur["id"]++;
            }
            $this->_nextIndex = $cur["id"];
        }
        else
        {
            $this->_nextIndex++;
        }
        return $this->_nextIndex;
    }

    /**
     * @desc returns the rowset by the selected field and value array
     * @param array $fieldValue
     * @return array|mixed
     */
    public function selectRowsetByFieldValue( $fieldValue = array() )
    {
        return Postgres::fetchRowInArrayByWhere(self::getTable()['table'], $fieldValue['field'], $fieldValue['value']);
    }

    /**
     * @desc selects only one field from the field value array and returns the result
     * @param array $fieldValue
     * @return array
     */
    public function selectFieldByFieldValue( $fieldValue = array() )
    {
        return Postgres::query("SELECT " . $fieldValue['field'] . " FROM " . self::getTable()['table'] . " WHERE " . $fieldValue['field'] . " = '" . $fieldValue['value'] . "';");
    }

    /**
     * @desc deletes all content in the table use with caution
     */
    public function truncateTable()
    {
        Postgres::query('DELETE FROM ' . self::getTable()['table'] . ';');
    }

    /**
     * @desc deletes entry by ID from the database
     * @param bool $id
     */
    public function deleteEntryById( $id = false )
    {
        if($id)
        {
            Postgres::query('DELETE FROM ' . self::getTable()['table'] . ' WHERE id = ' . $id . ';' );
        }
    }

    /**
     * @desc deletes entry by fieldname and value from the database
     * @param array $fieldValue
     */
    public function deleteEntryByFieldValue( $fieldValue = array() )
    {
        if(array_key_exists('field', $fieldValue))
        {
            Postgres::query("DELETE FROM " . self::getTable()['table'] . " WHERE " . $fieldValue["field"] . " = '" . $fieldValue["value"] . "'" );
        }
    }

    /**
     * @desc Loads the complete Table to an array, only use for small tables, otherwise load the table with its limits.
     * @param array $sortfield['name'], $sortfield['order'], or as in the followin example:
     *       q
     * @return array
     */
    public function loadTableToArray( $sortfield = array() )
    {
        if(sizeof($sortfield)>0)
        {
            $name = implode(', ', $sortfield['name']);
            $result = Postgres::query('SELECT * FROM ' . self::getTable()['table'] . ' ORDER BY ' . $name . ' ' . $sortfield['order']. ';');
        }
        else
        {
            $result = Postgres::query('SELECT * FROM ' . self::getTable()['table'] . ';');
        }
        return $result;
    }

    public function loadMultithreadCount()
    {
        if( $this->_multithreatCount < Postgres::getInstance()->getMultithreading() )
        {
            $this->_multithreatCount++;
        }
        else
        {
            $this->_multithreatCount = 0;
        }
        return $this->_multithreatCount;
    }

    /**
     * @desc returns the last inserted id from the corresponding table Model
     * @return mixed
     */
    public function getLastInsertID( $sequences = false )
    {

        try
        {
            if(!$sequences)
            {
                $result = Postgres::query('SELECT MAX(id) AS id FROM ' . self::getTable()['table'] . ';');
                return array_shift($result)["id"];
            }
            else
            {
                //Limbas sequence abfragen
                Postgres::query('SELECT last_value AS id FROM seq_' . self::getTable()['table'] . '_id ;');
                return array_shift($result)["id"];
            }
        }
        catch (\Exception $e)
        {
            throw new \Exception(print_r($e, true));
        }
    }

    /**
     * @desc gets the row count of a table
     * @return mixed
     */
    public function insertedRowCount()
    {
        $result = Postgres::query("SELECT count(*) as sum FROM " . self::getTable()['table'] . ";");
        return array_shift($result)['sum'];
    }

    /**
     * @desc returns all columns as an array from the current table
     * @return mixed|void
     */
    public function getAllColumnsAsArray()
    {
        $result = Postgres::query("SELECT * FROM information_schema.columns WHERE table_schema = 'public' AND table_name   = '" . self::getTable()['table'] . "';");
        return $result;
    }

    public function loadPasswordByUsername( $user_name = false )
    {
        //TODO: Implement the postgres query
    }

    /**
     * @desc select a row by the selected fieldset ( field and where value )
     * @param array $field
     * @return mixed
     */
    public function selectRowByFieldWhere( $field = array() )
    {
        //TODO: Implement the posgtes query
        //return Pdo::fetchRowInArrayByWhere(self::$table['table'], $field['field'], $field['value']);
    }
}