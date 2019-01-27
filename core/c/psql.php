<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 08.12.17
 * Time: 11:02
 */

class Psql extends Mysql implements IPsql
{
    use Messages;

    protected $_readOnly = false;

    private static $_instance;

    protected function __construct( $section = false )
    {
        if( $section )
        {
            $settings = Config::getInstance()->getConfig()[$section];
        }
        else
        {
            $section = Config::getInstance()->getConfig()[self::SETTINGS_DATABASE];
        }
        $this->_setUsername($settings[self::PLACE_USERNAME]);
        $this->_setPassword($settings[self::PLACE_PASSWORD]);
        $this->_setDbname($settings[self::PLACE_DATABASE]);
        $this->_setDiver($settings[self::PLACE_DRIVER]);
        $this->_setHostname($settings[self::PLACE_HOSTNAME]);
        $this->_setPort($settings[self::PLACE_PORT]);
        $this->_setReadOnly($settings[self::PLACE_READONLY]);
        $this->_setEncoding($settings[self::PLACE_ENCODING]);
        $this->_setMultithreading($settings[self::PLACE_MULTI_THREADING]);
        $this->_setDsn();
        $this->_setConn();
    }

    public static function getInstance( $section = false )
    {
        $className = get_called_class();
        if(self::$_instance==null) self::$_instance = new $className( $section );
        return self::$_instance;
    }

    /**
     * @param string $multithreading
     */
    private function _setMultithreading( $multithreading )
    {
        $this->_multithreading = $multithreading;
    }

    /**
     * @param string $dsn
     */
    private function _setDsn( )
    {
        $this->_dsn = 'host=' . $this->getHostname() . ' port=' . $this->getPort() . ' dbname=' .  $this->getDbname() . ' user=' . $this->getUsername() . ' password=' . $this->getPassword();
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
        $this->_conn = \pg_connect( $this->getDsn() );
    }

    /**
     * @param string $port
     */
    private function _setPort( $port )
    {
        $this->_port = $port;
    }

    /**
     * @param boolean $readOnly
     */
    protected function _setReadOnly( $readOnly )
    {
        $this->_readOnly = $readOnly;
    }

    /**
     * @param string $encoding
     */
    private function _setEncoding( $encoding )
    {
        $this->_encoding = $encoding;
    }





}