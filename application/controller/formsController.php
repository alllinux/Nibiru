<?php
namespace Nibiru;

use Nibiru\Adapter\Controller;
use Nibiru\Factory\Form;

class formsController extends Controller
{
    private $form;

    public function __construct()
    {
        Form::create();

        Form::addTypeLabel(
            array(
                'value'  => 'Full Name',
                'for'    => 'full-name',
                'class'  => 'contacts-label'
            )
        );

        Form::addInputTypeText(
            array(
                'name'     => 'full-name',
                'required' => 'required',
                'id'       => 'full-name',
                'class'    => 'contacts-input form-control'
            ),
            array(
                'class' => 'input-text'
            )
        );

        Form::addTypeLabel(
            array(
                'value'  => 'Email',
                'for'    => 'email',
                'class'  => 'contacts-label'
            )
        );

        Form::addInputTypeText(
            array(
                'name'     => 'email',
                'required' => 'required',
                'id'       => 'email',
                'class'    => 'contacts-input form-control'
            ),
            array(
                'class' => 'input-email'
            )
        );

        Form::addTypeButton(
            array(
                'class'  => 'btn-block btn-info',
                'name'   => 'Send Message'
            )
        );

        $this->form = Form::addForm(
            array(
                'name'   => 'newregister',
                'method' => 'post',
                'action' => 'YOURPOSTURL',
                'target' => '_self'
            )
        );
    }

    public function pageAction()
    {
        View::assign([
            'name' => 'rapid prototyping framework',
            'title' => 'Nibiru Forms Example',
            'formdata' => $this->form,
            'css'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.css"],
            'js'  => Config::getInstance()->getConfig()[View::NIBIRU_SETTINGS]["smarty.js"]
        ]);
    }

    public function navigationAction()
    {
        JsonNavigation::getInstance()->loadJsonNavigationArray();
    }

}