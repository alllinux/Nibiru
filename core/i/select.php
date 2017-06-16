<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:16
 * TODO: Write the corresponding class for the select dropdown of the form
 */
interface ISelect
{
    /**
     * @desc set the name for the select box
     * @param $selectName
     * @return mixed
     */
     public static function setSelectName($selectName);

    /**
     * @desc set the options array in the current form if present
     *       e.g.: array(
                            'names' => array('name1', 'name2'),
     *                      'value' => array('value1', 'value2')
     *                  )
     * @param $optionNames
     * @return mixed
     */
     public static function setOptionNames($optionNames);

    /**
     * @desc set the select type possible parameter values
     *       multiple, single
     * @param $selectType
     * @return mixed
     */
     public static function setSelectType($selectType);

    /**
     * @desc set the size of the select type if it is multiple
     * @param $selectTypeSize
     * @return mixed
     */
     public static function setSelectTypeSize($selectTypeSize);
}