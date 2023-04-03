<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:19
 */
class Display
{

    /**
     * Call this method to get singleton
     * @return Display
     */
    public static function getInstance()
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Display();
        }
        return $instance;
    }

    /**
     * Display constructor.
     */
    protected function __construct()
    {

    }

    public function display()
    {
        View::getInstance()->display(Router::getInstance()->tplName(true));
    }
}