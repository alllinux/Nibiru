<?php

namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 15:26
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */

class JsonNavigation extends Config
{
	const NAVIGATION = "navigation";

	private static $_navigation;
	private static $_navigation_array = array();
	private static $_instance;
	private static $_file_content_string = NULL;
	private static $_file_content_array = array();

	public static function getInstance()
	{
		parent::getInstance();
		self::setFileContentString();
		self::setFileContentArray();
		self::setNavigation();
		$className = get_called_class();
		if(self::$_instance==null) self::$_instance = new $className();
		return self::$_instance;
	}

	/**
	 * @return null
	 */
	protected static function getFileContentString( )
	{
		return self::$_file_content_string;
	}

	/**
	 * @param null $file_content
	 */
	private static function setFileContentString( )
	{
		self::$_file_content_string = file_get_contents( Settings::SETTINGS_PATH . self::getConfig()["SETTINGS"]["navigation"] );
	}

	/**
	 * @return array
	 */
	protected static function getFileContentArray( )
	{
		return self::$_file_content_array;
	}

	/**
	 * @param array $file_content_array
	 */
	private static function setFileContentArray( )
	{
		self::$_file_content_array = file( Settings::SETTINGS_PATH . self::getConfig()["SETTINGS"]["navigation"] );
	}

	/**
	 * @return array
	 */
	protected static function getNavigation( )
	{
		return self::$_navigation;
	}

	/**
	 * @param array $navigation
	 */
	private static function setNavigation( )
	{
		self::$_navigation = new \RecursiveIteratorIterator(
			new \RecursiveArrayIterator(
				json_decode( self::getFileContentString() , TRUE )
			), \RecursiveIteratorIterator::SELF_FIRST
		);
	}

	/**
	 * Displays the content of the file line by line on the
	 * screen if it is in json format
	 */
	public function displayRawJsonNavigation( )
	{
		foreach (self::getNavigation() as $key => $val)
		{
			if(is_array($val))
			{
				echo "$key:<br>\n";
			}
			else
			{
				echo "$key => $val<br>\n";
			}
		}
	}

	/**
	 * Loads the navigation from a json file into
	 * the view, making the variables available
	 */
	public function loadJsonNavigationArray( )
	{
		$nav = self::getNavigation();
		foreach ( $nav as $item => $value)
		{
			if($item == self::NAVIGATION)
			{
				$keys = array_keys($value);
				for($i=0; sizeof($keys)>$i;$i++)
				{
					self::$_navigation_array[] = array(
												'title'   => $keys[$i],
												'icon'    => $value[$keys[$i]]["icon"],
						                        'link'    => $value[$keys[$i]]["link"],
												'tooltip' => $value[$keys[$i]]["tooltip"],
					);
				}
			}
		}
		View::getInstance()->getEngine()->assignGlobal("navigationJson", self::$_navigation_array);
	}
}