<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: Stephan Kasdorf
 * Date: 12.02.18
 * Time: 19:58
 */

class TypeButton extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_VALUE            => '',
        self::FORM_ATTRIBUTE_ID     => '',
        self::FORM_ATTRIBUTE_CLASS  => '',
        self::FORM_NAME             => '',
        self::FORM_ATTRIBUTE_TYPE   => ''
    );

    public function loadElement( $attributes )
    {
        parent::__construct( $this->_attributes );
        $this->_setElement();
        $this->_setAttributes( self::loadAttributeValues( $attributes ) );
        return $this->getElement();
    }

    /**
     * @param mixed $element
     */
    private function _setElement( )
    {
        $this->_element = '<button type="TYPE" value="VALUE" ID CLASS>NAME' . "</button>\n";
    }

}