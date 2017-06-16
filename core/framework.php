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
require_once __DIR__ . '/i/soap.php';
require_once __DIR__ . '/c/soap.php';
require_once __DIR__ . '/i/auth.php';
require_once __DIR__ . '/c/auth.php';
require_once __DIR__ . '/c/debug.php';
require_once __DIR__ . '/c/display.php';
require_once __DIR__ . '/dispatch.php';