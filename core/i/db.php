<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 10.11.17
 * Time: 09:06
 */

interface IDb
{
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
     * @desc beacause there is no autoindex this has to be part of every database model
     *       class, so the next index is always correctly set
     * @return mixed
     */
    public function nextInsertIndex();



}