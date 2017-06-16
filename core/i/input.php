<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:16
 */

interface IInput
{
	/**
	 * @desc constant form types for this class
	 */
	const TYPE_CHECKBOX         = "checkbox";
	const TYPE_RADIO            = "radio";
	const TYPE_EMAIL            = "email";
	const TYPE_TEXT             = "text";
	const TYPE_HIDDEN           = "hidden";
	const TYPE_DATE             = "date";
	const TYPE_IMAGE            = "image";
	const TYPE_PASSWORD         = "password";
	const TYPE_WEEK             = "week";
	const TYPE_TIME             = "time";
	const TYPE_TEL              = "tel";
	const TYPE_SUBMIT           = "submit";
	const TYPE_BUTTON           = "button";
	const TYPE_URL              = "url";
	const TYPE_COLOR            = "color";
	const TYPE_DATETIME_LOCAL   = "datetime-local";
	/**
	 * TODO: Implement onClick for javascript form validation
	 *@desc Build Templates for the input form field
	 */
	const INPUT                 = "\t\t\t" . "<input name=\"{name}\" type=\"{type}\" value=\"{value}\" min=\"{min}\" max=\"{max}\">" . "\n";
	const INPUT_LABELED         = "\t\t\t" . "<label for=\"{name}\">{labelname}</label>"."<input name=\"{name}\" type=\"{type}\" value=\"{value}\" min=\"{min}\" max=\"{max}\">" . "\n";

    /**
     * @desc set the form fields, they must be passed within an
     *       array: array(
     *                      'fieldnames' => array('name', 'name' ...),
     *                      'fieldtypes' => 'array(text, radio ...)',
     *                      'min'       => array(number, number ...),
     *                      'max'       => array(number, nunber ...)
     *                    );
     * @param $fields
     * @return mixed
     */
    public function setInputFields($fields);

    /**
     * @desc offer the main types for an input field
     *       e.g. type="checkbox",
     *            type="radio",
     *            type="email",
     *            type="text",
     *            type="hidden",
     *            type="date",
     *            type="image"
     *            type="password"
     *            type="week"
     *            type="time"
     *            type="tel"
     *            type="submit"
     *            type="button"
     *            type="url"
     * @param (string) $type
     * @return (string)
     */

}