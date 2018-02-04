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
class View extends Controller implements IView
{
	private static $_instance;

	const NIBIRU_SETTINGS = "SETTINGS";
	const NIBIRU_SECURITY = "SECURITY";
	const NIBIRU_ROUTING = "ROUTING";
	const NIBIRU_FILE_END = ".tpl";

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
    public function getEngine()
    {
        return self::$engine;
    }

    /**
     * @param array $engine
     */
    public static function _setEngine( )
    {
        switch(Config::getInstance()->getConfig()[Engine::T_ENGINE][Engine::T_ENGINE_NAME])
        {
            case Engine::T_ENGINE_SMARTY:
                self::$engine = new \Smarty();
                self::$engine->setTemplateDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates"]);
                self::$engine->setCompileDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates_c"]);
                self::$engine->setCacheDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["cache"]);
                self::$engine->setConfigDir(__DIR__ . Config::getInstance()->getConfig()[Engine::T_ENGINE]["config_dir"]);
                self::$engine->assign('debuging', Config::getInstance()->getConfig()[Engine::T_ENGINE]["debugbar"]);
            break;
            case Engine::T_ENGINE_TWIG:
                $twig = new \Twig_Autoloader();
                $twig::register();
                self::$engine = new \Twig_Environment(new \Twig_Loader_Filesystem(Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates"]), array(
                    'cache' => Config::getInstance()->getConfig()[Engine::T_ENGINE]["cache"],
                ));
            break;
            case Engine::T_ENGINE_DWOO:
                // Implement Dwoo Template Engine
                self::$engine = new \Dwoo\Core();
                self::$engine->setCacheDir(Config::getInstance()->getConfig()[Engine::T_ENGINE]["cache"]);
                self::$engine->setCompileDir(Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates_c"]);
                self::$engine->setTemplateDir(Config::getInstance()->getConfig()[Engine::T_ENGINE]["templates"]);
                self::$engine->get('debugbar.tpl', array('debuging' => Config::getInstance()->getConfig()[Engine::T_ENGINE]["debugbar"]));
            break;
        }
    }

	public function assign( $varname = array() )
	{
		if(is_array($varname))
		{
			Controller::getInstance()->varname( $this->getEngine(), $varname );
		}
	}

	public static function forwardTo( $page )
	{
			header('Location: ' . $page);
			exit();
	}

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