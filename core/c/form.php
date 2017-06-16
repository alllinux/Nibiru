<?php
namespace Nibiru;
/**
 * Created by PhpStorm.
 * User: stephan
 * Date: 24.01.17
 * Time: 15:48
 */

class Form implements IForm
{
    use Messages;
    /**
     * @desc class wide parameters
     * @var
     */
    protected static $_instance;
	private static $fieldset_name;
    private static $action;
    private static $name;
    private static $type;
    private static $fields = array();
    private static $form = self::TYPE_FORM;

    protected function __construct($action, $name, $type)
    {
        try {
            if($action != "")
            {
                self::setFormAction($action);
            }
            if($name != "")
            {
                self::setFormName($name);
            }
            if($type != "")
            {
                self::setFormType($type);
            }
        } catch (\Exception $e)
        {
        	Debug::getInstance()->toDebug($e->getMessage());
        }
    }

    private static function setCurrentForm($form = self::TYPE_FORM)
    {
    	if(self::getFieldsetName())
	    {
	    	self::$form = self::TYPE_FORM_FIELDSET;
	    }
	    else
	    {
		    self::$form = $form;
	    }
    }

    protected static function getCurrentForm()
    {
        return self::$form;
    }

    /**
     * Call this method to get singleton
     *
     * @return Form
     */
    public static function getInstance($action, $name, $type)
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new Form($action, $name, $type);
        }
        return $instance;
    }

    public static function setFormAction($action)
    {
        try{
            if(is_string($action))
            {
                self::setCurrentForm(str_replace("{action}", $action, self::getCurrentForm()));
            }
            else
            {
                throw new \Exception(Messages::msg_error_string());
            }
        } catch (\Exception $e)
        {
            Debug::getInstance()->toDebug($e->getMessage());
        }

    }

    private static function getFormAction()
    {
        return self::$action;
    }

    public static function setFormName($name)
    {
        try{
            if(is_string($name))
            {
                self::setCurrentForm(str_replace("{name}", $name, self::getCurrentForm()));
            }
            else
            {
                throw new \Exception(Messages::msg_error_string());
            }
        } catch (\Exception $e)
        {
            Debug::getInstance()->toDebug($e->getMessage());
        }
    }

    /**
     * @desc set the form type corresponding to the HTML5 standard
     *
     * @param $type
     */
    public static function setFormType($type)
    {
        try{
            if(is_string($type))
            {
                self::setCurrentForm(str_replace("{type}", $type, self::getCurrentForm()));
            }
            else
            {
                throw new \Exception(Messages::msg_error_string());
            }
        } catch (\Exception $e)
        {
            Debug::getInstance()->toDebug($e->getMessage());
        }
    }

	/**
	 * @return mixed
	 */
	protected static function getFieldsetName()
	{
		return self::$fieldset_name;
	}

	/**
	 * @param mixed $fieldset_name
	 */
	private static function setFieldsetName( $fieldset_name )
	{
		self::$fieldset_name = $fieldset_name;
	}

    /**
     * @desc output the form with all current fields and values
     */
    public function displayForm()
    {
        // TODO: Implement displayForm() method.
    }

    public function addFieldset($name)
    {
			self::setFieldsetName($name);

    }
}