<?php
namespace Nibiru\Auto;
/**
 * Class    Auto
 * @project core
 * @desc    This is a PHP class file, please specify the use
 * @author  stephan - Nibiru Framework
 * @date    27.02.24
 * @time    13:35
 * @package Nibiru\Auto
 */
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Nibiru\Config;
use Nibiru\View;
class Auto
{
    const SETTINGS_SECTION          = "AUTOLOADER";
    const DB_MODEL_FOLDER           = "dbmodel";
    const SETTINGS_MODULE_SELECTOR  = "module";
    const SETTINGS_CLASS_POS        = "class.pos";
    const SETTINGS_TRAIT_POS        = "trait.pos";
    const FILTER_TRAIT_NAME         = "traits";
    const SETTINGS_IFACE_POS        = "iface.pos";
    const FILTER_INTERFACE_NAME     = "interfaces";
    const SETTINGS_CLASS_PLUGIN_POS = "class.plugin.pos";
    const FILTER_CLASS_PLUGIN_NAME  = "plugins";
    const REGEX_PATH_NAME           = "[NAME]";
    private array $configSettingsSection = [];
    private array $configAutoloaderSection = [];
    private static ?object $_instance = null;
    private string $modelFolderPath;
    private string $moduleFolderPath;

    /**
     * @desc Singleton instance
     */
    private function __construct()
    {
        $this->_set('configSettingsSection', Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]);
        $this->_set('configAutoloaderSection', Config::getInstance()->getConfig()[self::SETTINGS_SECTION]);
        $this->_set('modelFolderPath', $this->_get('configSettingsSection')[self::DB_MODEL_FOLDER]);
        $this->_set('moduleFolderPath', $this->_get('configSettingsSection')[self::SETTINGS_MODULE_SELECTOR]);
    }

    /**
     * @desc Singleton instance
     * @return Auto
     */
    public static function loader(): Auto
    {
        $className = get_called_class();
        if( self::$_instance === null )
        {
            self::$_instance = new $className();
        }
        return self::$_instance;
    }

    /**
     * @desc will set a given property for this class
     * @param string $name
     * @param $value
     * @return void
     */
    protected function _set(string $name, $value): void
    {
        try {
            $_class_properties = get_class_vars(__CLASS__);
            if (array_key_exists($name, $_class_properties))
            {
                $this->$name = $value;
            }
        } catch (\Exception $e) {
            error_log("Exception in _set method: " . $e->getMessage());
        } catch (\Error $e) {
            error_log("Error in _set method: " . $e->getMessage());
        }
    }
    /**
     * @desc will return the value of the requested property
     * @param string $name
     * @return mixed
     */
    protected function _get(string $name): mixed
    {
        try {
            $_class_properties = get_class_vars(__CLASS__);
            if (array_key_exists($name, $_class_properties))
            {
                return $this->$name;
            }
        } catch (\Exception $e) {
            error_log("Exception in _get method: " . $e->getMessage());
        } catch (\Error $e) {
            error_log("Error in _get method: " . $e->getMessage());
        }
    }

    /**
     * @desc Generic method to load files based on a given path and file pattern.
     * @param string $basePath The base path where the files are located.
     * @param string $pattern The regex pattern to match the files.
     * @return void
     */
    public function loadFiles(string $basePath, string $pattern = '/^.+\.php$/i')
    {
        $directoryIterator = new RecursiveDirectoryIterator($basePath);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $phpFiles = new RegexIterator($iterator, $pattern, \RecursiveRegexIterator::GET_MATCH);

        foreach ($phpFiles as $file) {
            require_once $file[0];
        }
    }

    /**
     * @desc Load all PHP model files from the specified directory.
     * @return void
     */
    public function loadModelFiles()
    {
        $this->loadFiles(__DIR__ . $this->_get('modelFolderPath'));
    }

    /**
     * @param $moduleName
     * @param $componentType
     * @param $registeredComponents
     * @return void
     */
    protected function loadModuleComponents($moduleName, $componentType, $registeredComponents): void
    {
        foreach ($registeredComponents as $componentName) {
            $componentBasePath = str_replace(self::REGEX_PATH_NAME, '', __DIR__ . $this->_get('moduleFolderPath')) . $moduleName;
            if ($componentType === self::FILTER_TRAIT_NAME || $componentType === self::FILTER_CLASS_PLUGIN_NAME || $componentType === self::FILTER_INTERFACE_NAME)
            {
                $componentPath = $this->determineComponentPath($componentName, $componentBasePath, $componentType);
            } else {
                $componentPath = $componentBasePath . '/' . $componentType . '/' . $componentName . '.php';
            }

            // Load the component if the file exists
            if (file_exists($componentPath))
            {
                require_once $componentPath;
            }
        }
    }

    // Example method to determine the path for special traits and plugins
    protected function determineComponentPath($componentName, $componentBasePath, $componentType)
    {
        // Placeholder logic to determine the correct path for traits and plugins
        // You might need to implement additional logic based on your framework's structure
        // For example, you might have a mapping or convention that relates component names to modules
        return $componentBasePath . '/' . $componentType . '/' . $componentName . '.php';
    }

    /**
     * Load modules by utilizing the generic loadFiles method.
     * @return void
     */
    public function loadModules(): void
    {
        $registeredModules = $this->_get('configAutoloaderSection')[self::SETTINGS_CLASS_POS];
        $modulePath = str_replace(self::REGEX_PATH_NAME, '', __DIR__ . $this->_get('moduleFolderPath'));

        foreach ($registeredModules as $moduleName) {
            $moduleMainFile = $modulePath . $moduleName . '/' . $moduleName . '.php';
            $this->loadModuleComponents($moduleName, self::FILTER_INTERFACE_NAME, $this->_get('configAutoloaderSection')[self::SETTINGS_IFACE_POS]);
            $this->loadModuleComponents($moduleName, self::FILTER_TRAIT_NAME, $this->_get('configAutoloaderSection')[self::SETTINGS_TRAIT_POS]);
            if (file_exists($moduleMainFile))
            {
                require_once $moduleMainFile;
            }

            $this->loadModuleComponents($moduleName, 'plugins', $this->_get('configAutoloaderSection')[self::SETTINGS_CLASS_PLUGIN_POS]);
        }
    }
}
