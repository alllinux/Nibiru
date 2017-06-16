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
    private $_template_engine;

    protected function __construct()
    {
        $this->_setConfig(Config::getInstance()->getConfig());
        $this->_setTemplateEngine();
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

    /**
     * @return mixed
     */
    public function getTemplateEngine()
    {
        return self::$_template_engine;
    }

    /**
     * @desc set the template engine implementation and make it
     * known class wide
     * @param mixed $template_engine
     */
    protected function _setTemplateEngine( )
    {
        switch(self::getConfig()[self::T_ENGINE][self::T_ENGINE_NAME])
        {
            case self::T_ENGINE_DWOO:
               $this->_template_engine = self::T_ENGINE_DWOO;
                require_once __DIR__ . '/../l/Dwoo/IDataProvider.php';
                require_once __DIR__ . '/../l/Dwoo/Data.php';
                require_once __DIR__ . '/../l/Dwoo/ICompiler.php';
                require_once __DIR__ . '/../l/Dwoo/Compiler.php';
                require_once __DIR__ . '/../l/Dwoo/ITemplate.php';
                require_once __DIR__ . '/../l/Dwoo/Template/Str.php';
                require_once __DIR__ . '/../l/Dwoo/Template/File.php';
                require_once __DIR__ . '/../l/Dwoo/Exception.php';
                require_once __DIR__ . '/../l/Dwoo/Plugin.php';
                require_once __DIR__ . '/../l/Dwoo/ICompilable.php';
                require_once __DIR__ . '/../l/Dwoo/ICompilable/Block.php';
                require_once __DIR__ . '/../l/Dwoo/IElseable.php';
                require_once __DIR__ . '/../l/Dwoo/Plugins/';
                require_once __DIR__ . '/../l/Dwoo/Block/Plugin.php';
                require_once __DIR__ . '/../l/Dwoo/Plugins/Blocks/PluginTopLevelBlock.php';
                require_once __DIR__ . '/../l/Dwoo/Exception.php';
                require_once __DIR__ . '/../l/Dwoo/ILoader.php';
                require_once __DIR__ . '/../l/Dwoo/Loader.php';
                require_once __DIR__ . '/../l/Dwoo/Core.php';

                require_once __DIR__ . '/../l/Dwoo/Smarty/Adapter.php';
                break;
            case self::T_ENGINE_TWIG:
                $this->_template_engine = self::T_ENGINE_TWIG;
                require_once __DIR__ . '/../l/Twig/Autoloader.php';
            break;
            case self::T_ENGINE_SMARTY:
            default:
                $this->_template_engine = self::T_ENGINE_SMARTY;
                require_once __DIR__ . '/../l/Smarty/Smarty.class.php';
            break;
        }
    }
}

Engine::getInstance();