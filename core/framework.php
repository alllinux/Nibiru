<?php
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 20:28
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
session_start();
/**
 * @desc Nibiru framework functionality
 * TODO: write a javascript controller handler
 * in order to be full scale compatible with limbas
 */
require_once __DIR__ . '/t/messages.php';
require_once __DIR__ . '/c/settings.php';
require_once __DIR__ . '/c/config.php';
require_once __DIR__ . '/c/router.php';
require_once __DIR__ . '/i/engine.php';
require_once __DIR__ . '/c/engine.php';
require_once __DIR__ . '/i/form.php';
require_once __DIR__ . '/c/form.php';
require_once __DIR__ . '/i/input.php';
require_once __DIR__ . '/c/input.php';
require_once __DIR__ . '/i/formfromtable.php';
require_once __DIR__ . '/c/formfromtable.php';
require_once __DIR__ . '/i/controller.php';
require_once __DIR__ . '/c/controller.php';
require_once __DIR__ . '/i/view.php';
require_once __DIR__ . '/c/view.php';
require_once __DIR__ . '/c/json-navigation.php';
require_once __DIR__ . '/i/mysql.php';
require_once __DIR__ . '/c/mysql.php';
require_once __DIR__ . '/i/pdo.php';
require_once __DIR__ . '/c/pdo.php';
require_once __DIR__ . '/i/odbc.php';
require_once __DIR__ . '/c/odbc.php';
require_once __DIR__ . '/i/postgres.php';
require_once __DIR__ . '/c/postgres.php';

/**
 * @desc currently unfinished
 */
require_once __DIR__ . '/i/soap.php';
require_once __DIR__ . '/c/soap.php';
require_once __DIR__ . '/i/auth.php';
require_once __DIR__ . '/c/auth.php';
/**
 * @desc main application starters
 */
require_once __DIR__ . '/c/debug.php';
require_once __DIR__ . '/c/display.php';
/**
 * @desc Framework dispatch process
 *       basic controller and action handling
 */
require_once __DIR__ . '/c/dispatcher.php';
/**
 * @desc Run the framework no game no gain
 */
Nibiru\Dispatcher::getInstance()->run();