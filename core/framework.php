<?php
/**
 * User       - stephan
 * Date       - 24.01.17
 * Time       - 20:28
 * @author    - Stephan Kasdorf
 * @category  - [PLEASE SPECIFIY]
 * @license   - BSD License
 */
if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}
/**
 * @desc Nibiru framework functionality
 */
require_once __DIR__ . '/t/messages.php';
require_once __DIR__ . '/t/pageination.php';
require_once __DIR__ . '/c/settings.php';
require_once __DIR__ . '/c/config.php';
require_once __DIR__ . '/c/registry.php';
require_once __DIR__ . '/c/router.php';
require_once __DIR__ . '/i/engine.php';
require_once __DIR__ . '/c/engine.php';
require_once __DIR__ . '/l/autoload.php';
/**
 * @desc Database connectivity
 */
require_once __DIR__ . '/i/mysql.php';
require_once __DIR__ . '/c/mysql.php';
require_once __DIR__ . '/i/pdo.php';
require_once __DIR__ . '/c/pdo.php';
/**
 * @desc Database ODBC support
 */
require_once __DIR__ . '/i/odbc.php';
require_once __DIR__ . '/c/odbc.php';
require_once __DIR__ . '/i/postgres.php';
require_once __DIR__ . '/c/postgres.php';
require_once __DIR__ . '/i/psql.php';
require_once __DIR__ . '/c/psql.php';
require_once __DIR__ . '/i/postgresql.php';
require_once __DIR__ . '/c/postgresql.php';
require_once __DIR__ . '/i/db.php';
require_once __DIR__ . '/i/pageination.php';
require_once __DIR__ . '/a/mysql.db.php';
require_once __DIR__ . '/a/postgres.db.php';
require_once __DIR__ . '/a/postgresql.db.php';
require_once __DIR__ . '/f/db.php';
require_once __DIR__ . '/a/pageination.php';
require_once __DIR__ . '/c/table.php';
require_once __DIR__ . '/c/model.php';
/**
 * @desc MVC functionality
 */
require_once __DIR__ . '/i/form.php';
require_once __DIR__ . '/f/form.php';
require_once __DIR__ . '/t/form.php';
require_once __DIR__ . '/c/formattributes.php';
require_once __DIR__ . '/c/form.php';
require_once __DIR__ . '/c/typetext.php';
require_once __DIR__ . '/c/typepassword.php';
require_once __DIR__ . '/c/typeemail.php';
require_once __DIR__ . '/c/typesubmit.php';
require_once __DIR__ . '/c/typetextarea.php';
require_once __DIR__ . '/c/typeradio.php';
require_once __DIR__ . '/c/typedate.php';
require_once __DIR__ . '/c/typedatetime.php';
require_once __DIR__ . '/c/typetelefon.php';
require_once __DIR__ . '/c/typesearch.php';
require_once __DIR__ . '/c/typehidden.php';
require_once __DIR__ . '/c/typebutton.php';
require_once __DIR__ . '/c/typeimagesubmit.php';
require_once __DIR__ . '/c/typenumber.php';
require_once __DIR__ . '/c/typereset.php';
require_once __DIR__ . '/c/typefileupload.php';
require_once __DIR__ . '/c/typecheckbox.php';
require_once __DIR__ . '/c/typecolor.php';
require_once __DIR__ . '/c/typeoption.php';
require_once __DIR__ . '/c/typeselect.php';
require_once __DIR__ . '/c/typerange.php';
require_once __DIR__ . '/c/typeurl.php';
require_once __DIR__ . '/c/typelabel.php';
require_once __DIR__ . '/i/view.php';
require_once __DIR__ . '/c/view.php';
require_once __DIR__ . '/i/controller.php';
require_once __DIR__ . '/c/controller.php';
require_once __DIR__ . '/a/controller.php';
require_once __DIR__ . '/c/jsonnavigation.php';
/**
 * @desc currently unfinished
 */
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