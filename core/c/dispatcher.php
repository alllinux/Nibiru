<?php
/**
 * Created by PhpStorm.
 * User: skasdorf
 * Date: 18.07.17
 * Time: 16:50
 */

namespace Nibiru;


final class Dispatcher
{
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
        Router::getInstance();
        Router::getInstance()->route();
        require_once __DIR__ . '/../../application/controller/' . Router::getInstance()->tplName() . 'Controller.php';
        $class = "Nibiru\\".\Nibiru\Router::getInstance()->tplName()."Controller";
        $controller = new $class();

        if(array_key_exists('_action', $_REQUEST))
        {
            $action = $_REQUEST['_action']."Action";
            $controller->navigationAction();
            $controller->$action();
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