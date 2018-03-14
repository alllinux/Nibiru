<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: Stephan Kasdorf
 * Date: 26.01.18
 * Time: 21:42
 */

class TypeFileUpload extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_NAME             => '',
        self::FORM_ATTRIBUTE_ID     => '',
        self::FORM_ATTRIBUTE_CLASS  => ''
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
        $this->_element = '<input type="file" name="NAME" ID CLASS>' . "\n";
    }



}