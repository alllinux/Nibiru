<?php
namespace Nibiru\Module;
/**
 * @desc this file is for the autoloader to function properly,
 * you might as well use it as the primary user class for your
 * application, the interface an the trait are currently implemented
 * Created by PhpStorm.
 * User: kasdorf
 * Date: 28.08.18
 * Time: 11:22
 */
use Nibiru\Adapter;
use Nibiru\Messages;

class Users implements Adapter\Users
{
    use Messages\Users;
}