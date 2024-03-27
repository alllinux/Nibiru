<?php
namespace Nibiru;

/**
 * Class    Module
 * @project src
 * @desc    This is a PHP class file, please specify the use
 * @author  stephan - Maschinen Stockert Großhandels GmbH
 * @date    27.03.24
 * @time    11:39
 * @package Nibiru
 */
class Module extends Adapter\Module
{
    /**
     * @desc Instance of the Module class
     * @return Module
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * @desc will set a given property for this class
     * @param string $name
     * @param $value
     * @return void
     */
    protected function _set(string $name, $value): void
    {
        try {
            $_class_properties = get_class_vars(get_called_class());
            if (array_key_exists($name, $_class_properties))
            {
                $this->$name = $value;
            }
        } catch (\Exception $e) {
            error_log("Exception in _set method: " . $e->getMessage());
        } catch (\Error $e) {
            error_log("Error in _set method: " . $e->getMessage());
        }
    }
    /**
     * @desc will return the value of the requested property
     * @param string $name
     * @return mixed
     */
    protected function _get(string $name): mixed
    {
        try {
            $_class_properties = get_class_vars(get_called_class());
            if (array_key_exists($name, $_class_properties))
            {
                return $this->$name;
            }
        } catch (\Exception $e) {
            error_log("Exception in _get method: " . $e->getMessage());
        } catch (\Error $e) {
            error_log("Error in _get method: " . $e->getMessage());
        }
    }
}