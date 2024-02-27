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
 * @deprecated - this class is deprecated, use the auto autoloader instead (c/auto.php)
 */
class Autoloader
{
    const MY_FILE_NAME              = "autoloader.php";
    const PHP_FILE_EXTENSION        = ".php";
    const DB_MODEL_FOLDER           = "dbmodel";
    const MODULE_FOLDER             = "module";
    const INTERFACE_FOLDER          = "interfaces";
    const TRAIT_FOLDER              = "traits";
    const PLUGINS_FOLDER            = "plugins";
    const SETTINGS_SECTION          = "AUTOLOADER";
    const SETTINGS_CLASS_POS        = "class.pos";
    const SETTINGS_TRAIT_POS        = "trait.pos";
    const SETTINGS_IFACE_POS        = "iface.pos";
    const SETTINGS_CLASS_PLUGIN_POS = "class.plugin.pos";
    const REGEX_PATH_NAME           = "[NAME]";
    
    private static $_filesInFoler = array();
    private static $_instance;
    private static $_debug = false;
    private static $_modules = array();
    
    protected function __construct()
    {
        self::_setFilesInFolder();
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
     * @param mixed $section
     * @return array
     */
    private static function sortOrderModules( array $modules, $section ): ?array
    {
        (bool) $skip = false;
        (array) $normal = array();
        (array) $first = array();
        (array) $sorted = array();
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
        if($section == self::SETTINGS_CLASS_PLUGIN_POS)
        {
            $moduleSortOrder = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_CLASS_PLUGIN_POS];
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
            if(is_array($first) && array_key_exists(0, $first))
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
            if(!strstr($file, self::PLUGINS_FOLDER))
            {
                $required[] = $file;
                require_once $file;
            }
            else
            {
                $plugins[] = $file;
            }
        }
        foreach($plugins as $plugin)
        {
            $required[] = $plugin;
            require_once $plugin;
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
     * @param string $moduleName
     * @return \RecursiveIteratorIterator
     */
    private static function folderContent( string $folderPath, string $moduleName = '' ): ?\RecursiveIteratorIterator
    {
        if(strstr($folderPath, self::REGEX_PATH_NAME) && $moduleName!="")
        {
            $folderPath = str_replace(self::REGEX_PATH_NAME, $moduleName, $folderPath);
        }
        if(is_dir($folderPath))
        {
            return new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator( $folderPath ));
        }
        else
        {
            return null;
        }
    }

    /**
     * @param array $filesInFoler
     */
    private static function _setFilesInFolder( )
    {
        /**
         * @desc arrays for sorting the module order, so they will load
         *       alphabetically
         */
        $modules = array();
        self::$_filesInFoler = array();
        
        if( is_array( Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] ) )
        {
            foreach ( Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER] as $modelfolder )
            {
                $iterator = self::folderContent( __DIR__ . $modelfolder );
                if($iterator!=null || is_array($iterator) || is_object($iterator))
                {
                    foreach ($iterator as $item)
                    {
                        if ($item->getFileName() != self::MY_FILE_NAME && $item->getFileName() != "." && $item->getFileName() != ".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                        {
                            self::$_filesInFoler[] = $item->getPathName();
                        }
                    }
                }
            }
        }
        else
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::DB_MODEL_FOLDER]);
            if($iterator != null)
            {
                foreach ($iterator as $item)
                {
                    if ($item->getFileName() != self::MY_FILE_NAME && $item->getFileName() != "." && $item->getFileName() != ".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                    {
                        self::$_filesInFoler[] = $item->getPathName();
                    }
                }
            }
        }
        /**
         * TODO: refactor this section
         */
        $moduleInterfaceNames = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_IFACE_POS];
        foreach($moduleInterfaceNames as $interfaceName)
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::INTERFACE_FOLDER], $interfaceName);
            if($iterator!=null || is_array($iterator) || is_object($iterator))
            {
                foreach ( $iterator as $item )
                {
                    if($item->getFileName() != self::MY_FILE_NAME && $item->getFileName() != "." && $item->getFileName() != ".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                    {
                        $interfaces[] = array(
                            'nfilename' => str_replace('.php', '', $item->getFileName()),
                            'filepathname' => $item->getPath() . '/' . $item->getFileName()
                        );
                    }
                }
            }
            if(is_array($interfaces))
            {
                asort($interfaces);
                $Sinterfaces = self::sortOrderModules($interfaces, self::SETTINGS_IFACE_POS);
                foreach ($Sinterfaces as $interface)
                {
                    if(!in_array($interface['filepathname'], self::$_filesInFoler))
                    {
                        self::$_filesInFoler[] = $interface['filepathname'];
                    }
                }
            }
        }
        $modulesTraitsNames = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_TRAIT_POS];
        foreach($modulesTraitsNames as $traitsName)
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::TRAIT_FOLDER], $traitsName );
            if($iterator!=null || is_array($iterator) || is_object($iterator))
            {
                foreach ( $iterator as $item )
                {
                    if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!=".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                    {
                        $traits[] = array(
                            'nfilename' => str_replace('.php', '', $item->getFileName()),
                            'filepathname'      => $item->getPath() . '/' . $item->getFileName()
                        );
                    }
                }
            }
            if(is_array($traits))
            {
                asort($traits);
                $Straits = self::sortOrderModules($traits, self::SETTINGS_TRAIT_POS);
                foreach($Straits as $trait)
                {
                    if(!in_array($trait['filepathname'], self::$_filesInFoler))
                    {
                        self::$_filesInFoler[] = $trait['filepathname'];
                    }
                }
            }
        }
        $modulesClassNames = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_CLASS_POS];
        foreach($modulesClassNames as $className)
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::MODULE_FOLDER], $className );
            if($iterator!=null || is_array($iterator) || is_object($iterator))
            {
                foreach ( $iterator as $item )
                {
                    if($item->getFileName()!= self::MY_FILE_NAME && $item->getFileName()!="." && $item->getFileName()!=".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                    {
                        $modules[] = array(
                            'nfilename' => str_replace('.php', '', $item->getFileName()),
                            'filepathname'      => $item->getPath() . '/' . $item->getFileName()
                        );
                    }
                }
            }
            if(is_array($modules))
            {
                asort($modules);
                $Smodules = self::sortOrderModules($modules, self::SETTINGS_CLASS_POS);
                foreach($Smodules as $smodule)
                {
                    if(!in_array($smodule['filepathname'], self::$_filesInFoler))
                    {
                        self::$_filesInFoler[] = $smodule['filepathname'];
                    }
                }
            }
        }
        $modulesPluginsNames = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_CLASS_POS];
        $pluginNames = Config::getInstance()->getConfig()[self::SETTINGS_SECTION][self::SETTINGS_CLASS_PLUGIN_POS];
        $plugins = [];
        foreach($modulesPluginsNames as $pluginsName)
        {
            $iterator = self::folderContent(__DIR__ . Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::PLUGINS_FOLDER], $pluginsName );
            foreach($pluginNames as $pluginName)
            {
                if(is_array($iterator) || is_object($iterator))
                {
                    foreach ($iterator as $item)
                    {
                        if (!empty($pluginName))
                        {
                            if (strstr($item->getFilename(), $pluginName))
                            {
                                if ($item->getFileName() != self::MY_FILE_NAME && $item->getFileName() != "." && $item->getFileName() != ".." && strstr($item->getFileName(), self::PHP_FILE_EXTENSION))
                                {
                                    $plugins[] = array(
                                        'nfilename' => str_replace('.php', '', $item->getFileName()),
                                        'filepathname' => $item->getPath() . '/' . $item->getFileName()
                                    );
                                }
                            }
                        }
                    }
                }
            }
            if(is_array($plugins))
            {
                asort($plugins);
                $Splugins = self::sortOrderModules($plugins, self::SETTINGS_CLASS_PLUGIN_POS);
                foreach($Splugins as $plugin)
                {
                    if(!in_array($plugin['filepathname'], self::$_filesInFoler))
                    {
                        self::$_filesInFoler[] = $plugin['filepathname'];
                    }
                }
            }
        }
    }
}