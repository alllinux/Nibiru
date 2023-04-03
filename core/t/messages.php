<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:57
 */

trait Messages
{
    /**
     * @desc messages for the form classes
     */
    public static function msg_error_string()
    {
        return "ERROR: The type has to be of type (string)!";
    }
    public static function msg_error_array()
    {
        return "ERROR: The given parameter type has to be an array (array)";
    }
    public static function msg_error_field_names()
    {
        $filednames = array('fieldnames' => array("name1", "name2", "etc"));
        return "ERROR: The field names have to in the form of an array: e.g.:" . "\n" . print_r($filednames, true);
    }
    public static function msg_error_field_max()
    {
        $max = array('max' => array(2, 3, 'etc'));
        return "ERROR: The field max has to be in the form of an array containing integers e.g:" . "\n" . print_r($max, true);
    }
    public static function msg_error_field_min()
    {
        $min = array('min' => array(2, 3, 'etc'));
        return "ERROR: The field min has to be in the form of an array containing integers e.g:" . "\n" . print_r($min, true);
    }
    public static function msg_error_input_array_size()
    {
        $size_array = array(    'fieldnames' => array('name', 'name', 'etc'),
                                'fieldtypes' => array('text', 'radio', 'etc'),
                                'fieldvalues' => array('value1', 'value2', 'etc'),
                                'min'       => array(5, 4, 'etc'),
                                'max'       => array(7, 8, 'etc')
                            );
        return "ERROR: The field size for the array has to be equal to 4, and has to contain the follwoing fields:" . "\n" . print_r($size_array, true);
    }
    public static function msg_error_input_values()
    {
        $values = array('min' => array('value1', 'value2', 'etc'));
        return "ERROR: The fieldvalues have to be in the form of an array containing values e.g:" . "\n" . print_r($values, true);
    }

    /**
     * @desc section for the debug class
     */
    public static function msg_post()
    {
        return 'No data for the $_POST output.';
    }
    public static function msg_get()
    {
        return 'No data for the $_GET output.';
    }
    public static function msg_files()
    {
        return 'No data for the $_FILES output.';
    }
    public static function msg_cookie()
    {
        return 'No data for the $_COOKIES output.';
    }
    public static function msg_session()
    {
        return 'No data for the $_SESSION output.';
    }
    public static function msg_env()
    {
        return 'No data for the $_ENV output.';
    }
    public static function msg_globals()
    {
        return 'No data for the $GLOBALS output.';
    }
    public static function msg_server()
    {
        return 'No data for the $_SERVER output.';
    }
    public static function msg_request()
    {
        return 'No data for the $_REQUEST output.';
    }
    public static function msg_raw_output()
    {
        return 'No data for the raw output.';
    }
    public static function msg_bottom_bar()
    {
        return 'Nibiru System Information.';
    }
    public static function msg_file_write_undefined()
    {
    	return 'ERROR: Marduk needs a filename, in  order to perform delete actions on the file!';
    }
}