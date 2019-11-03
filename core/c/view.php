<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 22:28
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
class View implements IView
{
	private static $_instance;

	const NIBIRU_SETTINGS 	= "SETTINGS";
	const NIBIRU_URL		= "pageurl";
	const NIBIRU_ERROR 		= "ERROR";
	const NIBIRU_SECURITY 	= "SECURITY";
	const NIBIRU_ROUTING 	= "ROUTING";
	const NIBIRU_EMAIL		= "EMAIL";
	const NIBIRU_FILE_END 	= ".tpl";

	private static $smarty  = array();
	private static $engine  = array();

	/**
	 * @desc not part of the core should be working standalone on the 
	 * $this->buildCsv() method
	 * @var int
	 */
	private $xmlPos = 0;
	
	protected function __construct()
	{
		Controller::getInstance();
		self::_setEngine();
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
    public function getEngine(): \Smarty
    {
        return self::$engine;
    }

    /**
     * Will setup the template engine
     */
    public static function _setEngine( )
    {
        self::$engine = new \Smarty();
        self::$engine->setTemplateDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates"]);
        self::$engine->setCompileDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates_c"]);
        self::$engine->setCacheDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["cache"]);
        self::$engine->setConfigDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["config_dir"]);
        self::$engine->setDebugTemplate(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["debug_template"] );
        self::$engine->assign('debuging', Config::getInstance()->getConfig()[Engine::T_ENGINE]["debugbar"]);
    }

    /**
     * @param array $varname
     */
	public function assign( $varname = array() )
	{
		if(is_array($varname))
		{
			Controller::getInstance()->varname( $this->getEngine(), $varname );
		}
	}

    /**
     * @param $page
     */
	public static function forwardTo( $page )
	{
			header('Location: ' . $page);
			exit();
	}

    /**
     * @param $page
     */
	public function display( $page )
	{
		preg_match_all("/".self::NIBIRU_FILE_END."/", $page, $matches);
		if(!array_key_exists(self::NIBIRU_FILE_END, array_flip(array_shift($matches))))
		{
			$page = str_replace("/", "", $page) . self::NIBIRU_FILE_END;
		}
		Controller::getInstance()->action( $this->getEngine(), $page );
	}

	/**
	 * @param mixed $xmlPos
	 */
	protected function _setXmlPos( $xmlPos )
	{
		$this->xmlPos = $xmlPos;
	}

	/**
	 * @return mixed
	 */
	protected function getXmlPos( )
	{
		return $this->xmlPos;
	}

    /**
     * @param $stuff
     * @param bool $die
     * @return string
     */
	protected static function printStuffToScreen( $stuff, $die = false )
	{
		$output = "<pre>" . print_r( $stuff, true ) . "</pre>";
		if( $die )
		{
			die( $output );
		}
		else
		{
			return $output;
		}
	}
}