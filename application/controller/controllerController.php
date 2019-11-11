<?php
namespace Nibiru;

use Nibiru\Adapter\Controller;

class controllerController extends Controller
{
    public function pageAction()
    {
        View::assign([
            'name' => 'rapid prototyping framework',
            'title' => 'Nibiru Controller Example',
            'ndbraw_output' => print_r(Registry::getInstance()->loadModuleConfigByName('users'), true),
            'css'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.css"],
            'js'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.js"]
        ]);
    }

    public function navigationAction()
    {
        JsonNavigation::getInstance()->loadJsonNavigationArray();
    }

}