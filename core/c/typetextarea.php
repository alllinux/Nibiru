<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 21:42
 */

class TypeTextarea extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_ATTRIBUTE_COLS           => '',
        self::FORM_VALUE                    => '',
        self::FORM_ATTRIBUTE_ROWS           => '',
        self::FORM_NAME                     => '',
        self::FORM_ATTRIBUTE_CLASS          => '',
        self::FORM_ATTRIBUTE_ID             => '',
        self::FORM_ATTRIBUTE_PLACEHOLDER    => '',
        self::FORM_ATTRIBUTE_REQUIRED       => ''
    );

    public function loadElement( $attributes )
    {
        parent::__construct( $this->_attributes );
        $this->_setElement();
        $this->_setAttributes( self::loadAttributeValues( $attributes ) );
        return $this->getElement();
    }

    /**
     * @return array
     */
    protected function getAttributes( )
    {
        return $this->_attributes;
    }

    /**
     * @param mixed $element
     */
    private function _setElement( )
    {
        $this->_element = '<textarea name="NAME" rows="ROWS" cols="COLS" placeholder="PLACEHOLDER" required="REQUIRED" ID CLASS>' . "VALUE" . '</textarea>' . "\n";
    }



}