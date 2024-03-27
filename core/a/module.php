<?php
namespace Nibiru\Adapter;

use Nibiru\IModule;
abstract class Module implements IModule
{
    /**
     * @desc will return the value of the requested property
     * @param string $name
     * @return mixed
     */
    abstract protected function _get(string $name);
    /**
     * @desc will set a given property for this class
     * @param string $name
     * @param $value
     * @return void
     */
    abstract protected function _set(string $name, $value): void;

}