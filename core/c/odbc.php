<?php
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 10.07.17
 * Time: 13:49
 */

namespace Nibiru;


class Odbc extends Mysql implements IOdbc
{
    use Messages;
    
    protected $_readOnly = false;
    
    private static $_instance;

    protected function __construct( $section = false )
    {
        if($section)
        {
            $settings = Config::getInstance()->getConfig()[$section];
        }
        else
        {
            $settings = Config::getInstance()->getConfig()[self::SETTINGS_DATABASE];
        }
        if($settings[self::PLACE_IS_ACTIVE])
        {
            $this->_setUsername($settings[self::PLACE_USERNAME]);
            $this->_setPassword($settings[self::PLACE_PASSWORD]);
            $this->_setDbname($settings[self::PLACE_DATABASE]);
            $this->_setDiver($settings[self::PLACE_DRIVER]);
            $this->_setHostname($settings[self::PLACE_HOSTNAME]);
            $this->_setPort($settings[self::PLACE_PORT]);
            $this->_setReadOnly($settings[self::PLACE_READONLY]);
            $this->_setDsn();
            $this->_setConn();
        }
        else
        {
            return false;
        }

    }

    public static function getInstance( $section = false )
    {
        $className = get_called_class();
        if(self::$_instance==null) self::$_instance = new $className( $section );
        return self::$_instance;
    }

    /**
     * @param string $dsn
     */
    private function _setDsn( )
    {
        $this->_dsn = 'Driver=' . $this->getDiver() . ';Server=' . $this->getHostname() . ';Port=' . $this->getPort() . ';Database=' .  $this->getDbname() . ';ReadOnly=' . $this->getReadOnly();
    }

    /**
     * @param string $username
     */
    private function _setUsername( $username )
    {
        $this->_username = $username;
    }

    /**
     * @param string $password
     */
    private function _setPassword( $password )
    {
        $this->_password = $password;
    }

    /**
     * @param mixed $diver
     */
    private function _setDiver( $diver )
    {
        $this->_diver = $diver;
    }

    /**
     * @param string $hostname
     */
    private function _setHostname( $hostname )
    {
        $this->_hostname = $hostname;
    }

    /**
     * @param string $dbname
     */
    private function _setDbname( $dbname )
    {
        $this->_dbname = $dbname;
    }

    /**
     * @param string $conn
     */
    private function _setConn( )
    {
        $this->_conn = \odbc_connect( $this->getDsn(), $this->getUsername(), $this->getPassword() );
    }

    /**
     * @param string $port
     */
    private function _setPort( $port )
    {
        $this->_port = $port;
    }

    /**
     * @return boolean
     */
    private function getReadOnly()
    {
        return $this->_readOnly;
    }

    /**
     * @param boolean $readOnly
     */
    protected function _setReadOnly( $readOnly )
    {
        $this->_readOnly = $readOnly;
    }
}