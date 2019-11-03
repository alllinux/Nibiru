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
    const MY_FILE_NAME          = "autoloader.php";
    const DB_MODEL_FOLDER       = "dbmodel";
    const MODULE_FOLDER         = "module";
    const INTERFACE_FOLDER      = "interfaces";
    const TRAIT_FOLDER          = "trait";
    const SETTINGS_SECTION      = "AUTOLOADER";
    const SETTINGS_CLASS_POS    = "class.pos";
    const SETTINGS_TRAIT_POS    = "trait.pos";
    const SETTINGS_IFACE_POS    = "iface.pos";
    
    private static $_filesInFoler = array();
    private static $_instance;
    private static $_debug = false;
    private static $_modules = array();
    
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
     * @return bool
     */
    protected static function isDebug(): bool
    {
        return self::$_debug;
    }
    
    /**
     * @desc activate debug into the debugbar, before calling the autoloader
     *       Autoloader::getInstance()->debug( true );
     * @param bool $debug
     */
    public static function debug( bool $debug ): void
    {
        self::$_debug = $debug;
    }
    
    /**
     * @desc will sort the array by a given sort order from the configuration file
     *       just provided in the AUTOLOADER section.
     * @param array $modules
     * @return array
     */
    private static function sortOrderModules( array $modules, $section ): array
    {
        (bool) $skip = false;
        (array) $normal = array();
        
        if($section == self::SETTINGS_CLASS_POS)
        {
            $moduleSortOrder = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_CLASS_POS];
        }
        if($section == self::SETTINGS_TRAIT_POS)
        {
            $moduleSortOrder = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_TRAIT_POS];
        }
        if($section == self::SETTINGS_IFACE_POS)
        {
            $moduleSortOrder = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_IFACE_POS];
        }
        if(sizeof($moduleSortOrder)>0)
        {
            foreach ($modules as $module)
            {
                foreach ($moduleSortOrder as $sortOrder)
                {
                    if($module['nfilename'] == $sortOrder)
                    {
                        $first[] = $module;
                    }
                    else
                    {
                        $skip = true;
                    }
                }
                if($skip)
                {
                    $normal[] = $module;
                    $skip = false;
                }
            }
            if(array_key_exists(0, $first))
            {
                $sorted = array();
                foreach($moduleSortOrder as $item)
                {
                    foreach ($first as $fmodule)
                    {
                        if($item==$fmodule['nfilename'])
                        {
                            $sorted[] = $fmodule;
                        }
                    }
                }
            }
            $modules = array_merge($sorted, $normal);
        }
        return $modules;
    }
    
    /**
     * @desc includes all database model files in preparation for the
     *       database factory model
     */
    public function runRequireOnce()
    {
        foreach (self::getFilesInFoler() as $file)
        {
            $required[] = $file;
            require_once $file;
        }
        if(self::isDebug())
        {
            View::getInstance()->assign(
                array(
                    'ndbraw_output' => '<pre>' . print_r($required, true) . '</pre>'
                )
            );
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
     * @return array
     */
    protected static function getModules(): array
    {
        return self::$_modules;
    }

    /**
     * @param string $folderPath
     * @return \RecursiveIteratorIterator
     */
    private static function folderContent( string $folderPath ): \RecursiveIteratorIterator
    {
        return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator( $folderPath ));
    }

    /**
     * @param array $filesInFoler
     */
    private static function _setFilesInFoler( )
    {
        /**
         * @desc arrays for sorting the module order, so they will load
         *       alphabetically
         */
        $modules = array();
        
        if( is_array( Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] ) )
        {
            foreach ( Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] as $modelfolder )
            {
                $iterator = self::folderContent( __DIR__ . $modelfolder );
                foreach ( $iterator as $item )
                {
                    if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
                    {
                        self::$_filesInFoler[] = $item->getPathName();
                    }
                }
            }
        }
        else
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] );
            foreach ( $iterator as $item )
            {
                if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
                {
                    self::$_filesInFoler[] = $item->getPathName();
                }
            }
        }
        /**
         * @desc run check on modules that should provide an interface as well as a trait
         */
        $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::INTERFACE_FOLDER] );
        foreach ( $iterator as $item )
        {
            if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
            {
                $interfaces[] = array(
                    'nfilename' => str_replace('.php', '', $item->getFileName()),
                    'filepathname'      => $item->getPath() . '/' . $item->getFileName()
                );
            }
        }
        asort($interfaces);
        $Sinterfaces = self::sortOrderModules($interfaces, self::SETTINGS_IFACE_POS);
        foreach ($Sinterfaces as $interface)
        {
            self::$_filesInFoler[] = $interface['filepathname'];
        }
        
        $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::TRAIT_FOLDER] );
        foreach ( $iterator as $item )
        {
            if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
            {
                $traits[] = array(
                    'nfilename' => str_replace('.php', '', $item->getFileName()),
                    'filepathname'      => $item->getPath() . '/' . $item->getFileName()
                );
            }
        }
        asort($traits);
        $Straits = self::sortOrderModules($traits, self::SETTINGS_TRAIT_POS);
        foreach($Straits as $trait)
        {
            self::$_filesInFoler[] = $trait['filepathname'];
        }
        
        $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::MODULE_FOLDER] );
        foreach ( $iterator as $item )
        {
            if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!="..")
            {
                $modules[] = array(
                    'nfilename' => str_replace('.php', '', $item->getFileName()),
                    'filepathname'      => $item->getPath() . '/' . $item->getFileName()
                );
            }
        }
        asort($modules);
        $Smodules = self::sortOrderModules($modules, self::SETTINGS_CLASS_POS);
        foreach ($Smodules as $module)
        {
            self::$_filesInFoler[] = $module['filepathname'];
        }
    }
}