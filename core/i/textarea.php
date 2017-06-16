<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:22
 * TODO: Write the class for the textareas
 */
interface ITextarea
{
    /**
     * @desc set the name of the text area
     * @param (string) $textareaName
     * @return (string)
     */
    public static function setTextareaName($textareaName);

    /**
     * @desc set the size of the text area
     * @param (int) $textareaSize
     * @return (int)
     */
    public static function setTextareaSize($textareaSize);

    /**
     * @desc set the textarea form name given by the father class
     *       e.g.:
     * @param (string) $textareaFormname
     * @return (string)
     */
    public static function setTextareaFormname($textareaFormname);
}