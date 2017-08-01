<?php
namespace Nibiru;
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 22:36
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
interface IController
{
	/**
	 * @desc start name for the current Controller
	 * 		 request search value for the Controller
	 */
	const START_CONTROLLER_NAME = "index";
	const CONTROLLER_REQUEST_NAME = "controller";
	
	/**
	 * This should be part of any extended controller
	 * class in order to implement a page structure
	 * @return array
	 */
	public function pageAction();

	/**
	 * This is the part where you can add titles to
	 * your page navigation.
	 */

	public function navigationAction();

	/**
	 * Here you can add any form data for handling in your
	 * controller
	 *
	 * @param bool $action
	 * @param string $name
	 * @param string $type
	 * @param bool $labeled
	 * @param array $data
	 *
	 * @return array
	 */
	public function formAction(	$action = false, $name = <<<NAME
NAME
								, $type = <<<METHOD
METHOD
								, $labeled = false , $data = array()
							  );

}