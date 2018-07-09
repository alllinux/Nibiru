<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 23:10
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */

class Router extends Config
{
	private static $_routing;
	private static $_cur_route = null;
	private static $_instance;
	private static $_cur_page;
	private static $_routes = array();
	private static $_action;

	protected function __construct()
	{

	}

	public static function getInstance()
	{
		self::loadRouting();
		$className = get_called_class();
		if(self::$_instance==null) self::$_instance = new $className();
		return self::$_instance;
	}

	private static function loadRouting()
	{
		Config::setConfig(Config::getInstance()->getEnv());
		self::$_routing = Config::getInstance()->getConfig()[View::NIBIRU_ROUTING];
		self::setRoutes(self::$_routing);
		self::setCurRoute();
	}

	/**
	 * @return mixed
	 */
	protected static function getCurRoute()
	{
		return self::$_cur_route;
	}

	/**
	 * @param mixed $cur_route
	 */
	private static function setCurRoute( )
	{
		if( self::getCurPage() != IController::START_CONTROLLER_NAME )
		{
			self::$_cur_route = self::getCurPage();
			if(self::getAction())
			{
				self::$_cur_route .= '/' . self::getAction() . '/';
			}
		}
		else
		{
			self::$_cur_route = IController::START_CONTROLLER_NAME;
		}
	}

	/**
	 * @return mixed
	 */
	public function getRoutes()
	{
		return self::$_routes;
	}

	/**
	 * @param mixed $routes
	 */
	private static function setRoutes( $routes )
	{
		self::$_routes = $routes;
	}

	/**
	 * @return mixed
	 */
	protected static function getAction()
	{
		return self::$_action;
	}

	/**
	 * @param mixed $action
	 */
	private static function setAction( $action )
	{
		$_REQUEST['_action'] = $action;
	}

	public function route()
	{
		self::setCurPage();
		$route_keys = array_keys(self::$_routing["route"]);
		$size_route_keys = sizeof($route_keys);

		for($i=0; $size_route_keys>$i; $i++)
		{
			if(self::$_routing["route"][$route_keys[$i]] == self::getCurPage())
			{
				return self::getCurPage();
			}
		}
	}

	public function tplName($ending = false)
	{
		self::setCurPage();
		if($ending)
		{
			return self::getCurPage() . ".tpl";
		}
		else
		{
			return self::getCurPage();
		}
	}
	/**
	 * @return mixed
	 */
	protected static function getCurPage()
	{
		return self::$_cur_page;
	}

	/**
	 * @param mixed $cur_page
	 */
	private static function setCurPage( )
	{
		if( self::getCurRoute() == null )
		{
			$uri_parts = explode('/', $_SERVER["REQUEST_URI"]);
			if(is_array($uri_parts))
			{
				if($uri_parts[1] == "")
				{
					self::$_cur_page = "index";
				}
				else
				{
					self::$_cur_page = $uri_parts[1];
					if(array_key_exists(2, $uri_parts))
					{
						self::setAction($uri_parts[2]);
					}
				}
			}
		}
		else
		{
			self::$_cur_page = self::getCurRoute();
		}
	}

	/**
	 * Returns an array with all the information about the current page
	 * post, get, request, current route, current page, current parameters
	 * @return array
	 */
	public function currentPage()
	{
		//self::RouterDebug(self::$_cur_page);
		return self::getCurPage();
	}

	public static function RouterDebug($value)
	{
		if(is_array($value))
		{
			echo "<pre>";
			print_r($value);
			echo "</pre>";
		}
		elseif(is_string($value))
		{
			echo '<br />' . $value;
		}
			die("DEBUG END ----->");

	}
}