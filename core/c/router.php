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
    private static $_page_params = array();

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
	public static function getRoutes()
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
        self::$_action = $action;
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
        preg_match('/\/'.self::getCurPage().'\//', $_SERVER['REQUEST_URI'], $matches);
        if(!array_key_exists(0, $matches))
        {
            self::setCurPage();
        }
        if($ending)
        {
            self::setPageParams( $_SERVER["REQUEST_URI"] );
            return self::getCurPage() . ".tpl";
        }
        else
        {
            self::setPageParams( $_SERVER["REQUEST_URI"] );
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
     * @desc sets the current page route in the router
     */
    private static function setCurPage( )
    {
        $params = false;
        $param_parts = explode('?', $_SERVER["REQUEST_URI"]);
        $uri_parts = explode('/', $param_parts[0]);

        if(is_array($uri_parts))
        {
            if (self::handleSeoUrls($uri_parts))
            {
                // SEO URL was handled, skip normal processing
                return;
            }
            if($uri_parts[1] == "")
            {
                self::$_cur_page = "index";
            }
            else
            {
                self::$_cur_page = $uri_parts[1];
                if(array_key_exists(2, $uri_parts) && $uri_parts[2]!="")
                {
                    self::setAction($uri_parts[2]);
                    $params = true;
                }
            }
            if($params)
            {
                self::setPageParams( $uri_parts );
            }
        }
        if( self::getCurRoute() != null )
        {
            self::$_cur_page = self::getCurRoute();
        }
    }
    /**
     * @desc will get the current page parameters concerning url parts
     *       e.g. Controller/Action/Param
     * @return array
     */
    public function getPageParams()
    {
        return self::$_page_params;
    }

    /**
     * @param array $page_params
     */
    private static function setPageParams( $uri_parts )
    {
        $skip = false;
        if(is_array($uri_parts))
        {
            for($i=2;sizeof($uri_parts)>$i;$i++)
            {
                if(is_string($uri_parts[$i]))
                {
                    if(array_key_exists($i+1, $uri_parts))
                    {
                        if(!is_numeric($uri_parts[$i]))
                        {
                            foreach(self::getRoutes()['route'] as $routing)
                            {
                                if(stristr($routing, '/' . self::getCurPage() . '/'.self::getAction().'/'))
                                {
                                    preg_match('/\{(.*?)\}/', $routing, $matches);
                                    preg_match('/\/' . self::getCurPage() . '\/' . self::getAction() . '\/\d+/', $_SERVER["REQUEST_URI"], $routematch);
                                    if(is_array($routematch))
                                    {
                                        if(array_key_exists(0, $routematch))
                                        {
                                            $param_key = $matches[1];
                                            $param = $routematch[0];
                                            if(is_string($param_key))
                                            {
                                                if(!$skip && !array_key_exists($param_key, $_REQUEST[$uri_parts[$i]] ))
                                                {
                                                    preg_match('|\d+|', $param, $digit);
                                                    $_REQUEST[$uri_parts[$i]] = array($param_key => $digit[0]);
                                                    $skip = true;
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if($skip)
                                    {
                                        if(!array_key_exists($uri_parts[$i], $_REQUEST))
                                        {
                                            $_REQUEST[$uri_parts[$i]] = $uri_parts[$i + 1];
                                        }
                                    }
                                    else
                                    {
                                        if(!array_key_exists($uri_parts[$i], $_REQUEST))
                                        {
                                            $_REQUEST[$uri_parts[$i]] = $uri_parts[$i + 1];
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }
        self::$_page_params = $_REQUEST;
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

    /**
     * @desc Generic SEO URL handler for framework-wide SEO-friendly URLs
     * @param array $uri_parts The URI parts from the request
     * @return bool Returns true if SEO URL was handled, false otherwise
     */
    private static function handleSeoUrls($uri_parts)
    {
        // Check if we have the minimum required parts for SEO URL: /controller/slug/id
        if (!is_array($uri_parts) || count($uri_parts) < 4)
        {
            return false;
        }

        // Extract components
        $controller = $uri_parts[1] ?? '';
        $slug = $uri_parts[2] ?? '';
        $possibleId = $uri_parts[3] ?? '';

        // Validate that the last part is numeric (ID)
        if (!is_numeric($possibleId))
        {
            return false;
        }

        // Validate that the slug contains non-numeric characters (to differentiate from traditional URLs)
        if (is_numeric($slug))
        {
            return false;
        }

        // Validate that the slug is not an existing action name
        if (self::isExistingAction($controller, $slug))
        {
            return false;
        }

        // SEO URL detected - transform it to standard routing
        self::$_cur_page = $controller;
        self::setAction('detail'); // Default action for SEO URLs
        $_REQUEST['id'] = $possibleId;
        $_REQUEST['slug'] = $slug; // Preserve slug for potential use in controllers

        return true;
    }

    /**
     * @desc Check if a slug matches an existing controller action
     * @param string $controller The controller name
     * @param string $slug The potential action/slug
     * @return bool Returns true if it's an existing action
     */
    private static function isExistingAction($controller, $slug)
    {
        // List of common actions that should not be treated as SEO slugs
        $commonActions = ['detail', 'list', 'edit', 'delete', 'create', 'update', 'page', 'navigation', 'requestForm'];

        return in_array($slug, $commonActions, true);
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