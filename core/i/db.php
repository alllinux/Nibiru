<?php
namespace Nibiru\Adapter;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 10.11.17
 * Time: 09:06
 */

interface IDb
{
    /**
     * @desc updates a row by a given field and field where search value
     * @param false $wherefield
     * @param false $wherevalue
     * @param false $rowfield
     * @param false $rowvalue
     * @return mixed
     */
    public function updateRowByFieldWhere( $wherefield = false, $wherevalue = false, $rowfield = false, $rowvalue = false );
    /**
     * will return the last inserted id of the given table
     * @return int
     */
    public function lastInsertId();

    /**
     * @desc Will load the given database table as an array
     * @return mixed
     */
    public function loadTableAsArray();

    /**
     * @desc Has to select a given Rowset by the index ID of the table
     * @param bool $id
     * @return mixed
     */
    public function selectRowsetById( $id = false );

    /**
     * @desc inserts a rowset into the table, by the given nextInsertIndex return
     *       value for the table
     * @param bool $id
     * @param array $rowset
     * @return mixed
     */
    public function insertRowsetById( $rowset = array(), $id = false );

    /**
     * @desc in order to have a page navigation a dataset should also be selectable
     *       by a min and max value, result limitation
     * @param bool $min
     * @param bool $max
     * @return mixed
     */
    public function selectDatasetByMinMax( $min = false, $max = false );

    /**
     * @desc insert a given array by a format into the table of the database
     * @param array $dataset
     * @return mixed
     */
    public function insertArrayIntoTable( $dataset = array() );

    /**
     * @desc will return a result array from the searched where field from the database
     *       containing the entire dataset rows
     * @param array $fieldWhere
     * @return mixed
     */
    public function selectDatasetByFieldWhere( $fieldWhere = array() );

    /**
     * @desc selects a row by the fieldname and the given value, should be
     *       array('fieldname' => 'value')
     * @param array $field
     * @return mixed
     */
    public function selectRowByFieldWhere( $field = array() );
    /**
     * @desc beacause there is no autoindex this has to be part of every database model
     *       class, so the next index is always correctly set
     * @return mixed
     */
    public function nextInsertIndex();

    /**
     * @desc loads the password from the datbaase for remembering
     * @param bool $user_name
     * @return mixed
     */
    public function loadPasswordByUsername( $user_name = false );
}