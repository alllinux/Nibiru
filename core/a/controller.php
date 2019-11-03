<?php
namespace Nibiru\Adapter;
/**
 * User       - stephan
 * Date       - 03.11.19
 * Time       - 18:50
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
use Nibiru\IController;
use Nibiru;

abstract class Controller extends Nibiru\Controller implements IController
{
    /**
     * This should be part of any extended controller
     * class in order to implement a page structure
     * @return array
     */
    abstract public function pageAction();

    /**
     * This is the part where you can add titles to
     * your page navigation.
     */

    abstract public function navigationAction();
}