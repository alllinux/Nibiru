<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 11:18
 */

class Input extends Form implements IInput
{
    use Messages;

    /**
     * @desc class wide parameters
     * @var string
     */
    private static $_currentInput = self::INPUT;
    private static $_inputFields = array();
    private static $_labeled = false;

    protected function __construct($action, $name, $type, $labeled)
    {
        parent::getInstance($action, $name, $type);
    }

    public static function load($action = false, $name, $type, $labeled=false)
    {
        self::setLabeled($labeled);
        if( self::$_instance == null )
        {
            self::$_instance = new Input($action, $name, $type, $labeled);
        }
        return self::$_instance;
    }

    /**
     * @return bool
     */
    protected static function isLabeled()
    {
        return self::$_labeled;
    }

    /**
     * @param bool $labeled
     */
    protected function setLabeled($labeled=false)
    {
        self::$_labeled = $labeled;
    }

    /**
     * @desc accesor method for building the input fields
     * @param $fields
     * @throws \Exception
     */
    public function setInputFields($fields)
    {
        try {
            if(is_array($fields))
            {
                if(self::isLabeled())
                {
                    self::$_currentInput = self::INPUT_LABELED;
                }
                if(sizeof($fields)==5) {
                    $keys = array_keys($fields);
                    for ($i = 0; sizeof($keys)>$i; $i++) {
                        if ($keys[$i] == "fieldnames") {
                            try {
                                if (is_array($fields[$keys[$i]])) {
                                    for ($a = 0; sizeof($fields[$keys[$i]]) > $a; $a++) {
                                        if($fields["fieldtypes"][$a]=="submit")
                                        {
                                            if(self::isLabeled())
                                            {
                                                $submit = str_replace("<label for=\"{name}\">{labelname}</label>", "", self::getCurrentInput());
                                                $submit = str_replace("name=\"{name}\"", "", $submit);
                                            }
                                            else
                                            {
                                                $submit = str_replace("name=\"{name}\"", "", self::getCurrentInput());
                                            }
                                            self::$_inputFields[] = str_replace("{value}", $fields[$keys[$i]][$a], $submit);
                                        }
                                        else
                                        {
                                            if($fields["fieldtypes"][$a]===self::TYPE_HIDDEN)
	                                        {
		                                        self::$_inputFields[] = str_replace("{name}", $fields[$keys[$i]][$a], self::INPUT);
	                                        }
	                                        else
	                                        {
		                                        $inputname = str_replace("{name}", $fields[$keys[$i]][$a], self::getCurrentInput());
		                                        self::$_inputFields[] = str_replace("{labelname}", $fields[$keys[$i]][$a], $inputname);
	                                        }
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                throw new \Exception(Messages::msg_error_field_names());
                            }

                        }
                        if ($keys[$i] == "fieldvalues") {
                            try {
                                if (is_array($fields[$keys[$i]])) {
                                    try {
                                        if (is_array($fields[$keys[$i]])) {
                                            for ($j = 0; sizeof($fields[$keys[$i]]) > $j; $j++) {
                                                if($fields[$keys[$i]][$j]==false)
                                                {
                                                    self::$_inputFields[$j] = str_replace("value=\"{value}\"", "", self::$_inputFields[$j]);
                                                }
                                                else
                                                {
                                                    self::$_inputFields[$j] = str_replace("{value}", $fields[$keys[$i]][$j], self::$_inputFields[$j]);
                                                }
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        throw new \Exception(Messages::msg_error_input_values());
                                    }
                                }
                            } catch (\Exception $e) {
                                throw new \Exception(Messages::msg_error_input_values());
                            }
                        }
                        if ($keys[$i] == "fieldtypes") {
                            try {
                                if (is_array($fields[$keys[$i]])) {
                                    for ($b = 0; sizeof($fields[$keys[$i]]) > $b; $b++) {
                                        switch ($fields[$keys[$i]][$b]) {
                                            case self::TYPE_BUTTON:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_BUTTON, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_CHECKBOX:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_CHECKBOX, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_DATE:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_DATE, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_EMAIL:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_EMAIL, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_HIDDEN:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_HIDDEN, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_IMAGE:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_IMAGE, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_TEL:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_TEL, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_RADIO:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_RADIO, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_PASSWORD:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_PASSWORD, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_SUBMIT:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_SUBMIT, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_TIME:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_TIME, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_WEEK:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_WEEK, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_URL:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_URL, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_TEXT:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_TEXT, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_COLOR:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_COLOR, self::$_inputFields[$b]);
                                                break;
                                            case self::TYPE_DATETIME_LOCAL:
                                                self::$_inputFields[$b] = str_replace("{type}", self::TYPE_DATETIME_LOCAL, self::$_inputFields[$b]);
                                                break;
                                        }
                                    }
                                }
                            } catch (\Exception $e) {
                                throw new \Exception(Messages::msg_error_field_types());
                            }
                        }
                        if ($keys[$i] == "min") {
                            try {
                                if (is_array($fields[$keys[$i]])) {
                                    try {
                                        if (is_array($fields[$keys[$i]])) {
                                            for ($c = 0; sizeof($fields[$keys[$i]]) > $c; $c++) {
                                                if($fields[$keys[$i]][$c]==false)
                                                {
                                                    self::$_inputFields[$c] = str_replace("min=\"{min}\"", "", self::$_inputFields[$c]);
                                                }
                                                else
                                                {
                                                    self::$_inputFields[$c] = str_replace("{min}", $fields[$keys[$i]][$c], self::$_inputFields[$c]);
                                                }
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        throw new \Exception(Messages::msg_error_field_min());
                                    }
                                }
                            } catch (\Exception $e) {
                                throw new \Exception(Messages::msg_error_field_min());
                            }
                        }
                        if ($keys[$i] == "max") {
                            try {
                                if (is_array($fields[$keys[$i]])) {
                                    try {
                                        if (is_array($fields[$keys[$i]])) {
                                            for ($d = 0; sizeof($fields[$keys[$i]]) > $d; $d++) {
                                                if($fields[$keys[$i]][$d]==false)
                                                {
                                                    self::$_inputFields[$d] = str_replace("max=\"{max}\"", "", self::$_inputFields[$d]);
                                                }
                                                else
                                                {
                                                    self::$_inputFields[$d] = str_replace("{max}", $fields[$keys[$i]][$d], self::$_inputFields[$d]);
                                                }
                                            }
                                        }
                                    } catch (\Exception $e) {
                                        throw new \Exception(Messages::msg_error_field_max());
                                    }
                                }
                            } catch (\Exception $e) {
                                throw new \Exception(Messages::msg_error_field_max());
                            }
                        }
                    }
                    self::setCurrentInput();
                    $fields = self::$_inputFields;
                    self::$_inputFields = "";
                    for($i=0;sizeof($fields)>$i;$i++)
                    {
                        self::$_inputFields .= $fields[$i];
                    }
                }
            }
            else
            {
                throw new \Exception(Messages::msg_error_input_array_size());
            }

        } catch (\Exception $e)
        {
            throw new \Exception(Messages::msg_error_array());
        }
    }

    /**
     * @desc get all input fields for the display
     * @return array
     */
    private static function getInputFields()
    {
        return self::$_inputFields;
    }

    /**
     * @desc set the current replacement for the input field
     * @param string $input
     */
    private static function setCurrentInput($input = self::INPUT)
    {
        self::$_currentInput = $input;
    }

    /**
     * @desc transfer method for the Template replacement
     * @return string
     */
    private static function getCurrentInput()
    {
        return self::$_currentInput;
    }

    /**
     * @desc diplay the current form with the input fields
     */
    public function displayForm()
    {
        return str_replace("{fields}", self::getInputFields(), self::getCurrentForm());
    }
}