<?php
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 18.07.17
 * Time: 16:50
 */

namespace Nibiru;
use Nibiru\Auto\Auto;
require_once __DIR__ . '/../c/auto.php';

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
        date_default_timezone_set(Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]['timezone']);
        if(Config::getInstance()->getConfig()[self::CONFIG_GENERATOR_SECTION][self::GENERATOR_DATABASE])
        {
            new Model( false );
        }
        Router::getInstance();
        Router::getInstance()->route();
        Auto::loader()->loadModelFiles();
        Auto::loader()->loadModules();
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
        else
        {
            // Soft 404: Route to error controller for non-existent pages
            // Load error controller and template from config [ENGINE] section
            $errorControllerName = Config::getInstance()->getConfig()[Engine::T_ENGINE]['error_controller'];
            $errorTemplate = Config::getInstance()->getConfig()[Engine::T_ENGINE]['error_template'];

            require_once __DIR__ . '/../../application/controller/' . $errorControllerName . 'Controller.php';
            $class = "Nibiru\\" . $errorControllerName . "Controller";
            $controller = new $class();
            $controller->navigationAction();
            $controller->pageAction();

            Debug::getInstance();
            View::getInstance()->display($errorTemplate);
        }
    }
}