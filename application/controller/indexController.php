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

class indexController extends View implements IController
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
        		'css'  => Config::getInstance()->getConfig()[View::ATM_SETTINGS]["smarty.css"],
				'js'  => Config::getInstance()->getConfig()[View::ATM_SETTINGS]["smarty.js"]
			)
		);
	}

	public function navigationAction()
	{
		JsonNavigation::getInstance()->loadJsonNavigationArray();
	}

	public function formAction(	$action = false, $name = "", $type = "", $labeled = false, $data = array() )
	{
		// TODO: Implement formAction() method.
	}
}