<?php
namespace Nibiru;

/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 10:20
 */
interface IForm
{
	/**
	 * @desc Basic Form template
	 */
	const TYPE_FORM              = "<form action=\"{action}\" method=\"{type}\" name=\"{name}\">" . "\n" . "{fields}" . "\n" . "<input type='submit' value='speichern'>\t\t" . "</form>" . "\n";
	const TYPE_FORM_FIELDSET     = "<form action=\"{action}\" method=\"{type}\" name=\"{name}\">"."\n"."<fieldset><label>{flname}</label>" . "\n" . "{fields}" . "\n" . "<input type='submit' value='speichern'>" . "\t\t" . "</fieldset>"."\n"."</form>" . "\n";
    /**
     * @desc add the form action in order to set the path
     *       for the controller
     * @param $action
     * @return mixed
     */
    public static function setFormAction($action);

    /**
     * @desc set the form type, two types (post, get)
     * @param $type
     * @return mixed
     */
    public static function setFormType($type);

    /**
     * @desc set the name for the form
     * @param $name
     * @return mixed
     */
    public static function setFormName($name);

    /**
     * @desc display the form data on the html layout
     * @return mixed
     */
    public function displayForm();
}