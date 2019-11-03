<?php
namespace Nibiru;
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
	}

	public static function getInstance(): View
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
	 * @return string
	 */
	public function getController()
	{
		return $this->_controller;
	}

	/**
	 * @param string $controller
	 */
	protected function setController( $controller )
	{
		$this->_controller = $controller;
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
	 * @return array
	 */
	public function getPost()
	{
		return $_POST;
	}

	/**
	 * @return array
	 */
	public function getGet()
	{
		return $_GET;
	}

	/**
	 * @return array
	 */
	public function getRequest()
	{
		return $_REQUEST;
	}

	/**
	 * @return mixed
	 */
	public function getServer()
	{
		return $_SERVER;
	}
}