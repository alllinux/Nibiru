<?php
namespace Nibiru\Factory;
use Nibiru\Form\TypeButton;
use Nibiru\Form\TypeCheckbox;
use Nibiru\Form\TypeCloseDiv;
use Nibiru\Form\TypeColor;
use Nibiru\Form\TypeDatetime;
use Nibiru\Form\TypeEmail;
use Nibiru\Form\TypeFileUpload;
use Nibiru\Form\TypeHidden;
use Nibiru\Form\TypeImageSubmit;
use Nibiru\Form\TypeLabel;
use Nibiru\Form\TypeNumber;
use Nibiru\Form\TypeOpenDiv;
use Nibiru\Form\TypeOption;
use Nibiru\Form\TypePassword;
use Nibiru\Form\TypeRadio;
use Nibiru\Form\TypeRange;
use Nibiru\Form\TypeReset;
use Nibiru\Form\TypeSearch;
use Nibiru\Form\TypeSelect;
use Nibiru\Form\TypeSubmit;
use Nibiru\Form\TypeTelefon;
use Nibiru\Form\TypeTextarea;
use Nibiru\Form\TypeText;
use Nibiru\Form\TypeDate;
use Nibiru\Form\TypeUrl;

/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 20:57
 */

class Form
{
    private static $element;
    private static $form;
    private static $option;
    private static $div = false;

    /**
     * @desc is used internaly for assambly only
     * @param $option
     */
    private static function assembleOptions( $option )
    {
        if($option == false)
        {
            self::$option = "";
        }
        else
        {
            self::$option .= $option;
        }
    }

    /**
     * @desc is used internally for assambly only
     * @param $select
     * @return mixed
     */
    private static function displaySelect( $select )
    {
        return str_replace( 'OPTIONS', self::$option, $select );
    }

    /**
     * @desc clear all form data in order to build a new one
     */
    public static function create()
    {
        self::$form = "";
    }

    /**
     * @desc is used internally for assambly only
     * @param $element
     */
    private static function assemble( $element )
    {
        if( self::getDiv() )
        {
            if(is_string(self::getDiv()))
            {
                $element = str_replace('ELEMENT', $element, self::getDiv());
                self::setDiv(false);
            }
        }
        self::$form .= $element;
    }

    /**
     * @desc replaces the final form fields into the form tags
     * @param $form
     * @return mixed
     */
    private static function display( $form )
    {
        return str_replace( 'FIELDS', self::$form, $form );
    }

    /**
     * @return mixed
     */
    protected static function getDiv( )
    {
        return self::$div;
    }

    /**
     * @param mixed $div
     */
    private static function setDiv( $div = false )
    {
        if($div != false)
        {
            if( is_array( $div ) )
            {
                foreach ( $div as $key=>$selector )
                {
                    self::$div = '<div ' . $key . '="' . $selector . '">' . "\n" . 'ELEMENT</div>' . "\n";
                }
            }
            else
            {
                self::$div = false;
            }
        }
        else
        {
            self::$div = false;
        }
    }

    /**
     * @return mixed
     */
    protected static function getElement()
    {
        return self::$element;
    }

    /**
     * @param mixed $element
     */
    private static function setElement( $element )
    {
        self::$element = $element;
    }

    /**
     * @desc adds the form tags around the form has to be called in the end, after adding all fields
     * @param $attributes
     * @return mixed
     */
    public static function addForm( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new \Nibiru\Form\Form() );
        return self::display( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an input type Textfield
     * @param $attributes
     */
    public static function addInputTypeText( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeText() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an input type Submit
     * @param $attributes
     */
    public static function addInputTypeSubmit( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeSubmit() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an input textarea field with the size of the column and the rows
     * @param $attributes
     */
    public static function addInputTypeTextarea( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeTextarea() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an input type of a radio button, should be a selection of
     *       more then one
     * @param $attributes
     */
    public static function addInputTypeRadio( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeRadio() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an input type of a Checkbox button, should be a tick more of one
     * @param $attributes
     */
    public static function addInputTypeCheckbox( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeCheckbox() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a input field for password entry
     * @param $attributes
     */
    public static function addInputTypePassword( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypePassword() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a calendar field with the given date value
     * @param $attributes
     */
    public static function addInputTypeDate( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeDate() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a field for entering the email address
     * @param $attributes
     */
    public static function addInputTypeEmail( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeEmail() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a field for entering a color-picker field
     * @param $attributes
     */
    public static function addInputTypeColor( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeColor() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a field for entering a date and time field
     * @param $attributes
     */
    public static function addInputTypeDatetime( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeDatetime() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a file upload field to the form
     * @param $attributes
     */
    public static function addTypeFileUpload( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeFileUpload() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a hidden field to the form
     * @param $attributes
     */
    public static function addTypeHidden( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeHidden() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an image as the submit button to the form
     * @param $attrbutes
     */
    public static function addTypeImageSubmit( $attrbutes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeImageSubmit() );
        self::assemble( self::getElement()->loadElement( $attrbutes ) );
    }

    /**
     * @desc adds a field for entering a number
     * @param $attributes
     */
    public static function addTypeNumber( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeNumber() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a control for entering a number whose exact value is not important (like a slider control).
     *       Default range is from 0 to 100, to the form
     * @param $attributes
     */
    public static function addTypeRange( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeRange() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a reset button (resets all form values to default values), to the form
     * @param $attributes
     */
    public static function addTypeReset( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeReset() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a text field for entering a search string to the form
     * @param $attributes
     */
    public static function addTypeSearch( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeSearch() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a field for entering a telefon number
     * @param $attributes
     */
    public static function addTypeTelefon( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeTelefon() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a field for entering a URL to the form
     * @param $attributes
     */
    public static function addTypeUrl( $attributes, $div = false )
    {
        if($div)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeUrl() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a select area to the form, should be added to the form after
     *       an option field has been added
     * @param $attributes
     */
    public static function addSelect( $attributes, $div = false )
    {
        if($div!=false)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeSelect() );
        self::assemble( self::displaySelect( self::getElement()->loadElement( $attributes ) ) );
        self::assembleOptions( false );
    }

    /**
     * @desc adds a form element as button to the form
     * @param $attributes
     * @param bool $div
     */
    public static function addTypeButton( $attributes, $div = false )
    {
        if($div!=false)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeButton() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an option field to the form, should be used upfront to the select field
     * @param $attributes
     */
    public static function addSelectOption( $attributes )
    {
        self::setElement( new TypeOption() );
        self::assembleOptions( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a label to the form element
     * @param $attributes
     */
    public static function addTypeLabel( $attributes, $div = false )
    {
        if($div!=false)
        {
            self::setDiv( $div );
        }
        self::setElement( new TypeLabel() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds an opening div to the form element
     * @param $attributes
     */
    public static function addOpenDiv( $attributes )
    {
        self::setElement( new TypeOpenDiv() );
        self::assemble( self::getElement()->loadElement( $attributes ) );
    }

    /**
     * @desc adds a closing div to the form element
     */
    public static function addCloseDiv( )
    {
        self::setElement( new TypeCloseDiv() );
        self::assemble( self::getElement()->loadElement( false ) );
    }
}
