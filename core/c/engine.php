<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 10.05.17
 * Time: 10:45
 */
class Engine implements IEngine
{
    private static $_instance;
    private $_config        = array();

    protected function __construct()
    {
        $this->_setConfig(Config::getInstance()->getConfig());
    }

    public static function getInstance()
    {
        $className = get_called_class();
        if( self::$_instance == null )
        {
            self::$_instance = new $className();
        }
        return self::$_instance;
    }
    /**
     * @return array
     */
    protected function getConfig()
    {
        return $this->_config;
    }

    /**
     * @param array $config
     */
    protected function _setConfig( $config )
    {
        $this->_config = $config;
    }
}

Engine::getInstance();