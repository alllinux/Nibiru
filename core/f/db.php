<?php

namespace Nibiru\Factory;
use Nibiru\Autoloader\Autoloader;

require_once __DIR__ . '/../c/autoloader.php';
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 10.11.17
 * Time: 09:24
 */
class Db
{
    protected static $_model = null;

    /**
     * @desc loads the database model through the correct Factory,
     *       all database functionallity has to be run trough this
     *       factory
     * @param string $modelName
     * @return null
     * @throws \Exception
     */
    public static function loadModel( $modelName = "")
    {
        try {
            if( $modelName != "" )
            {
                Autoloader::getInstance()->runRequireOnce();
                self::_setModel( $modelName );
                return self::getModel();
            }
        } catch(\Exception $e)
        {
            throw new \Exception( $e->getMessage() );
        }
    }

    /**
     * @return null
     */
    protected static function getModel()
    {
        return self::$_model;
    }

    /**
     * @param null $model
     */
    private static function _setModel( $model )
    {
        $fmodel = "\\Nibiru\\Model\\".$model;
        self::$_model = new $fmodel;
    }

}