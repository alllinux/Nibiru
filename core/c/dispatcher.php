<?php
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 18.07.17
 * Time: 16:50
 */

namespace Nibiru;
use Nibiru\Autoloader\Autoloader;
require_once __DIR__ . '/../c/autoloader.php';

final class Dispatcher
{
    const CONFIG_GENERATOR_SECTION = 'GENERATOR';
    const GENERATOR_DATABASE       = 'database';
    const GENERATOR_DB_OVERWRITE   = 'database.overwrite';

    private static $_instance;

    protected function __construct()
    {

    }

    public static function getInstance()
    {
        $className = get_called_class();
        if(self::$_instance==null) self::$_instance = new $className();
        return self::$_instance;
    }

    public function run()
    {
        if(Config::getInstance()->getConfig()[self::CONFIG_GENERATOR_SECTION][self::GENERATOR_DATABASE])
        {
            new Model( false );
        }
        Router::getInstance();
        Router::getInstance()->route();
        Autoloader::getInstance()->runRequireOnce();
        if(is_file(__DIR__ . '/../../application/controller/' . Router::getInstance()->tplName() . 'Controller.php'))
        {
            require_once __DIR__ . '/../../application/controller/' . Router::getInstance()->tplName() . 'Controller.php';
            $class = "Nibiru\\".\Nibiru\Router::getInstance()->tplName()."Controller";
            $controller = new $class();
            if(array_key_exists('_action', $_REQUEST))
            {
                $action = $_REQUEST['_action']."Action";
                $controller->navigationAction();
                if($action!="Action" && !strstr($action, '?'))
                {
                    if(method_exists($controller, $action))
                    {
                        $controller->$action();
                    }
                }
                $controller->pageAction();
            }
            else
            {
                $controller->navigationAction();
                $controller->pageAction();
            }

            Debug::getInstance();
            Display::getInstance()->display();
        }
    }
}