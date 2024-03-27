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
    const START_CONTROLLER_NAME = "index";
    const SESSION_ACTIVE = 'SESSION ACTIVE';
    const SESSION_DISABLED = 'SESSION DISABLED';
    const SESSION_KEY_NOT_FOUND = 'KEY NOT FOUND';
    const SESSION_KEY_VALUE_NOT_FOUND = 'KEY VALUE NOT FOUND';

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

}