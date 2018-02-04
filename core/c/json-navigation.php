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
	private static $_name = false;
	private static $_section_name = self::NAVIGATION;

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
	 * @return string
	 */
	protected static function getSectionName()
	{
		return self::$_section_name;
	}

	/**
	 * @param string $section_name
	 */
	private static function setSectionName( $section_name )
	{
		self::$_section_name = $section_name;
	}

	/**
	 * @return boolean
	 */
	protected static function getName()
	{
		return self::$_name;
	}

	/**
	 * @param boolean $name
	 */
	private static function setName( $name )
	{
		self::$_name = $name;
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
		self::$_file_content_string = file_get_contents( Settings::SETTINGS_PATH . parent::getInstance()->getConfig()["SETTINGS"][self::getSectionName()] );
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
		self::$_file_content_array = file( Settings::SETTINGS_PATH . parent::getInstance()->getConfig()["SETTINGS"][self::getSectionName()] );
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
	public function loadJsonNavigationArray( $name = false )
	{
		if( $name )
		{
			self::$_navigation_array = array();
			self::setSectionName( $name );
			self::setName( $name );
			parent::getInstance();
			self::setFileContentString();
			self::setFileContentArray();
			self::setNavigation();
		}
		$nav = self::getNavigation();
		foreach ( $nav as $item => $value)
		{
			if($item == self::getSectionName())
			{
				$keys = array_keys($value);
				for($i=0; sizeof($keys)>$i;$i++)
				{
					if(array_key_exists('link', $value[$keys[$i]]))
					{
						self::$_navigation_array[] = array(
							'title'   => $keys[$i],
							'icon'    => $value[$keys[$i]]["icon"],
							'link'    => $value[$keys[$i]]["link"],
							'tooltip' => $value[$keys[$i]]["tooltip"]
						);	
					}
					elseif(array_key_exists('onclick', $value[$keys[$i]]))
					{
						self::$_navigation_array[] = array(
							'title'   => $keys[$i],
							'icon'    => $value[$keys[$i]]["icon"],
							'tooltip' => $value[$keys[$i]]["tooltip"],
							'onclick' => $value[$keys[$i]]["onclick"]
						);
					}					
				}
			}
		}
		if( $name )
		{
			View::getInstance()->getEngine()->assignGlobal(self::getName(), self::$_navigation_array);
		}
		else
		{
			View::getInstance()->getEngine()->assignGlobal("navigationJson", self::$_navigation_array);
		}
	}
}