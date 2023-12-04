<?php
namespace Nibiru;
use Cassandra\Type\Map;

/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 22:01
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */

class Controller extends View
{
    private static $_instance;
    private $_config        = array();
    protected $_request     = array();
    protected $_get         = array();
    protected $_post        = array();
    private $_current       = array();
    private $_next          = array();
    private $_controller	= "index";

    protected function __construct()
    {
        $this->_setConfig(Config::getInstance()->getConfig());
        $this->_setController();
    }

    public static function getInstance(): View|Controller
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

    /**
     * @desc will return the current controller name
     * @return string
     */
    public function getController(): string
    {
        return $this->_controller;
    }

    /**
     * @desc will set the current controller name
     * @param string $controller
     */
    protected function _setController( string $controller = "" )
    {
        if($controller!="")
        {
            $this->_controller = $controller;
        }
        else
        {
            $url = explode("/", $_SERVER['REQUEST_URI']);
            $this->_controller = $url[1];
        }
    }

    /**
     * @param $template
     * @param $page
     */
    public function action( $template, $page )
    {
        $this->_setCurrent( $this->getNext() );
        $this->_setNext( $page );
        $template->display( $this->getNext() );
    }

    public function varname( $template, $varname = array() )
    {
        if(is_array($varname))
        {
            $template->assign($varname);
        }
    }

    /**
     * @return array
     */
    protected function getCurrent()
    {
        return $this->_current;
    }

    /**
     * @param array $current
     */
    private function _setCurrent( $current )
    {
        $this->_current = $current;
    }

    /**
     * @return array
     */
    protected function getNext()
    {
        return $this->_next;
    }

    /**
     * @param array $next
     */
    public function _setNext( $next )
    {
        $this->_next = $next;
    }

    /**
     * @param string $param
     * @param bool $params
     * @return string|array
     */
    public function getPost( string $param, bool $params = false )
    {
        if($param!="")
        {
            return $_POST[$param];
        }
        elseif($params)
        {
            return $_POST;
        }
    }

    /**
     * @param string $param
     * @param bool $params
     * @return string|array
     */
    public function getGet( string $param, bool $params = false )
    {
        if($param!="")
        {
            return $_GET[$param];
        }
        elseif($params)
        {
            return $_GET;
        }
    }

    /**
     * @param string $param
     * @param bool $params
     * @return string|array
     */
    public function getRequest( string $param, bool $params = false )
    {
        if($param!="")
        {
            return $_REQUEST[$param];
        }
        elseif($params)
        {
            return $_REQUEST;
        }
    }

    /**
     * @param string $param
     * @param bool $params
     * @return string|array
     */
    public function getServer( string $param, bool $params = false )
    {
        if($param!="")
        {
            return $_SERVER[$param];
        }
        elseif($params)
        {
            return $_SERVER;
        }
    }

    /**
     * @param string $param
     * @param bool $params
     * @return string|array
     */
    public function getFiles( string $param, bool $params = false )
    {
        if($param!="")
        {
            return $_FILES[$param];
        }
        elseif($params)
        {
            return $_FILES;
        }
    }

    /**
     * @param string $param
     * @param bool $params
     * @param bool $checkForActiveSession
     * @return string|array
     */
    public function getSession( string $param, bool $params = false, bool $checkForActiveSession = false ): string|array
    {
        if($checkForActiveSession)
        {
            if(session_status() == PHP_SESSION_DISABLED || sizeof($_SESSION) == 0)
            {
                return IController::SESSION_DISABLED;
            }
            elseif(session_status() == PHP_SESSION_NONE && sizeof($_SESSION) == 0)
            {
                return IController::SESSION_DISABLED;
            }
            else
            {
                return IController::SESSION_ACTIVE;
            }
        }
        else
        {
            if($param!="")
            {
                if(session_status() == PHP_SESSION_NONE)
                {
                    session_start();
                }
                if(session_status() == PHP_SESSION_ACTIVE)
                {
                    if (array_key_exists($param, $_SESSION))
                    {
                        if($_SESSION[$param] != null)
                        {
                            return $_SESSION[$param];
                        } else {
                            return IController::SESSION_KEY_VALUE_NOT_FOUND;
                        }
                    } else {
                        return IController::SESSION_KEY_NOT_FOUND;
                    }
                }
                else
                {
                    return IController::SESSION_DISABLED;
                }
            }
            elseif($params)
            {
                if(session_status() == PHP_SESSION_ACTIVE)
                {
                    return $_SESSION;
                }
                else
                {
                    return IController::SESSION_DISABLED;
                }
            }
        }
    }
}