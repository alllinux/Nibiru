<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 20:16
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
class Settings
{
	const SETTINGS_FILE = "settings.ENV.ini";
	const SETTINGS_PATH = "application/settings/config/";

	private static $_config;
	private static $_instance;
	private static $_is_db_connection = false;

	protected function __construct( )
	{
		//Constructor
	}

	public static function getInstance()
	{
		$className = get_called_class();
		if(self::$_instance==null) self::$_instance = new $className();
		return self::$_instance;
	}
	/**
	 * @return mixed
	 */
	public function getConfig( )
	{
		return self::$_config;
	}

	/**
	 * in order to have the class serve connection
	 * details switch to db connection
	 */
	public static function setToDbConnection()
	{
		self::$_is_db_connection = true;
	}

	/**
	 * in order to switch back from a database
	 * connection
	 */
	public static function unsetFromDbConnection()
	{
		self::$_is_db_connection = false;
	}
	/**
	 * @param mixed $config
	 */
	public static function setConfig( $env )
	{
		if($env)
		{
			$current_settings_file = str_replace('.ENV.', '.'.$env.'.', self::SETTINGS_FILE);
			if(file_exists(self::SETTINGS_PATH . $current_settings_file))
			{
				self::$_config = parse_ini_file(self::SETTINGS_PATH . $current_settings_file, "SETTINGS");
			}
			elseif(file_exists('../' . self::SETTINGS_PATH . $current_settings_file))
			{
				if($env==config::CLI_SYSTEM)
				{
					if(self::$_is_db_connection)
					{
						self::$_config = parse_ini_file('../' . self::SETTINGS_PATH . $current_settings_file, "SETTINGS");
					}
					else
					{
						self::$_config = parse_ini_file('../' . self::SETTINGS_PATH . $current_settings_file, "EMAIL");
					}
				}
				else
				{
					self::$_config = parse_ini_file('../' . self::SETTINGS_PATH . $current_settings_file, View::NIBIRU_SETTINGS);
				}
			}
		}
		else
		{
			throw new Exception("ERROR: The environment is unknown, please check with the server Administrator!");
		}
	}


}