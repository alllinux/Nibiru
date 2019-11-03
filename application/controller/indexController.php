<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 23:08
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
use Nibiru\Adapter\Controller;

class indexController extends Controller
{
	public function __construct()
	{
		
	}

	public function pageAction()
	{
        View::getInstance()->assign(
			array(
				'name' => 'Beispielseite',
				'title' => 'Stephan Kasdorf - Nibiru Example',
        		'css'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.css"],
				'js'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.js"]
			)
		);
	}

	public function navigationAction()
	{
		JsonNavigation::getInstance()->loadJsonNavigationArray();
	}
}