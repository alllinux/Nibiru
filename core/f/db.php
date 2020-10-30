<?php
namespace Nibiru\Factory;
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 10.11.17
 * Time: 09:24
 */
use Nibiru\Adapter\IDb;

class Db
{
    const DATABASE_DRIVER_NS    = "driver";
    protected static $_model    = null;

    /**
     * @desc loads the database model through the correct Factory,
     *       all database functionallity has to be run trough this
     *       factory
     * @param string $modelName
     * @return IDb
     * @throws \Exception
     */
    public static function loadModel( $modelName = ""): IDb
    {
        try {
            if( $modelName != "" )
            {
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