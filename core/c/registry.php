<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 11.11.19
 * Time       - 17:20
 * @author    - alllinux.de GbR
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
use Nibiru\Auto\Auto;

final class Registry
{
    const CONFIG_MODULE_KEY     = 'module';
    const CONFIG_SETTINGS_KEY   = 'settings';

    private $_modules_config = array();
    private $_module_name = '';
    private $_modules_path = '';

    private static $_instance;

    protected function __construct()
    {

    }

    public static function getInstance(): Registry
    {
        $className = get_called_class();
        if(self::$_instance==null) self::$_instance = new $className();
        self::$_instance->loadModuleRegistry();
        return self::$_instance;
    }

    /**
     * @return string
     */
    private function getModulesPath(): string
    {
        return $this->_modules_path;
    }

    /**
     * set the path to the modules
     */
    private function _setModulesPath( ): void
    {
        $this->_modules_path = __DIR__ . str_replace(Auto::REGEX_PATH_NAME, '', Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS][self::CONFIG_MODULE_KEY]);
    }

    /**
     * @return array
     */
    private function getModulesConfig(): array
    {
        return $this->_modules_config;
    }

    /**
     * set the modules configuration by module name
     */
    private function _setModulesConfig( ): void
    {
        $modules_setting_path = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getModulesPath()));
        foreach($modules_setting_path as $settings)
        {
            if(strstr($settings->getPathName(), self::CONFIG_SETTINGS_KEY) && $settings->getFileName()!='.' && $settings->getFileName()!='..')
            {

                $config_ini_name = basename($settings->getPathName());
                $ini_file = explode('.', $config_ini_name);
                $ini_file = $ini_file[0] . '.' . Config::getEnv() . '.' . $ini_file[1];
                $ini_file = str_replace($config_ini_name, $ini_file, $settings->getPathName()) . "<br>";
                if(!file_exists($ini_file))
                {
                    $ini_file = $settings->getPathName();
                }
                $module = new \stdClass();
                $module_settings = parse_ini_file($ini_file, true);
                if(array_key_exists(strtoupper($this->getModuleName()), $module_settings))
                {
                    foreach ($module_settings[strtoupper($this->getModuleName())] as $key=>$value)
                    {
                        $module->$key = $value;
                    }
                    $this->_modules_config[$this->getModuleName()] = $module;
                }
            }
        }
    }

    /**
     * @return string
     */
    private function getModuleName(): string
    {
        return $this->_module_name;
    }

    /**
     * @param string $module_name
     */
    private function _setModuleName(string $module_name): void
    {
        $this->_module_name = $module_name;
        $this->_setModulesPath();
        $this->_setModulesConfig();
    }

    /**
     * @return void
     */
    private function loadModuleRegistry(): void
    {
        foreach(Config::getInstance()->getConfig()[Auto::SETTINGS_SECTION][Auto::SETTINGS_CLASS_POS] as $module)
        {
            $this->_setModuleName($module);
        }
    }

    /**
     * @param string $module_name
     * @return object
     */
    public function loadModuleConfigByName(string $module_name): object
    {
        return $this->getModulesConfig()[$module_name];
    }

    /**
     * @desc will reset the registry
     */
    public function destroy()
    {
        self::$_instance = NULL;
    }
}