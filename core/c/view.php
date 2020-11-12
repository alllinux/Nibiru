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

    /**
     * @return View
     */
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
     * @param array $varname
     */
	public static function assign( $varname = array() )
    {
        if(is_array($varname))
        {
            Controller::getInstance()->varname( self::getInstance()->getEngine(), $varname );
        }
    }

    /**
     * @return \Smarty
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
        if(array_key_exists('caching', Config::getInstance()->getConfig()[Engine::T_ENGINE]) && Config::getInstance()->getConfig()[Engine::T_ENGINE]['caching']==true)
        {
            self::$engine->setCaching( \Smarty::CACHING_LIFETIME_CURRENT );
        }
        self::$engine->setCacheDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["cache"]);
        self::$engine->setConfigDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["config_dir"]);
        self::$engine->setDebugTemplate(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["debug_template"] );
        self::$engine->assign('debuging', Config::getInstance()->getConfig()[Engine::T_ENGINE]["debugbar"]);
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
     * @param string $encoding
     * @desc setting response to application json headers
     */
    public static function forwardToJsonHeader( string $encoding = "" )
    {
        header(self::NIBIRU_CONTENT_TYPE_JSON, true);
        header(self::NIBIRU_CONTENT_TYPE_CONNECTION, true);
        header(self::NIBIRU_CONTENT_ENCODING, true);
        if(strlen($encoding)>0)
        {
            header(str_replace('{transfer}', $encoding, self::NIBIRU_CONTENT_TRANSFER_ENCODING));
        }
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