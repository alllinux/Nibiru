<?php
namespace Nibiru\Autoloader;
use Nibiru\Config;
use Nibiru\View;

require_once __DIR__ . '/../i/db.php';
/**
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 10.11.17
 * Time: 09:44
 */
class Autoloader
{
    const MY_FILE_NAME      = "autoloader.php";
    const DB_MODEL_FOLDER   = "dbmodel";
    const MODUL_FOLDER      = "modul";

    private static $_filesInFoler = array();
    private static $_instance;

    protected function __construct()
    {
        self::_setFilesInFoler();
    }

    public static function getInstance()
    {
        $className = get_called_class();
        if(self::$_instance==null) self::$_instance = new $className();
        return self::$_instance;
    }

    /**
     * @desc includes all database model files in preparation for the
     *       database factory model
     */
    public function runRequireOnce()
    {
        foreach (self::getFilesInFoler() as $file)
        {
            require_once $file;
        }
    }

    /**
     * @return array
     */
    private static function getFilesInFoler()
    {
        return self::$_filesInFoler;
    }

    /**
     * @param array $filesInFoler
     */
    private static function _setFilesInFoler( )
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] ));
        foreach ($iterator as $item)
        {
            if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
            {
                self::$_filesInFoler[] = $item->getPathName();
            }
        }
    }


}