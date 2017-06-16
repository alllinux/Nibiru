<?php
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 20:22
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
Nibiru\Router::getInstance();
Nibiru\Router::getInstance()->route();
require_once __DIR__ . '/../application/controller/' . Nibiru\Router::getInstance()->tplName() . 'Controller.php';
eval("new Nibiru\\".Nibiru\Router::getInstance()->tplName()."Controller();");
Nibiru\Debug::getInstance();
Nibiru\Display::getInstance()->display();