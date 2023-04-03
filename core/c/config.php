<?php
namespace Nibiru;

/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 19:24
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
class Config extends Settings
{
	const STAGING_SYSTEM = "staging";
	const PRODUCTION_SYSTEM = "production";
	const DEVELOPMENT_SYSTEM = "development";
	const CLI_SYSTEM = "cli";

	private static $_env;

	public static function getInstance()
	{
		self::setEnv();
		parent::setConfig(self::getEnv());
		return parent::getInstance();
	}

	/**
	 * @return mixed
	 */
	public static function getEnv()
	{
		return self::$_env;
	}

	/**
	 * @param mixed $env
	 */
	private static function setEnv( )
	{
		if( getenv("APPLICATION_ENV") )
		{
			self::$_env = getenv("APPLICATION_ENV");
		}
		else
		{
            defined('APPLICATION_ENV')
            || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
            self::$_env = APPLICATION_ENV;
		}
	}


}