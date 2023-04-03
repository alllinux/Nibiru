<?php
namespace Nibiru\Form;
use Nibiru\Adapter;
/**
 * Copyright 2020 Nibiru Framework
 * Licence:     BSD 4-Old License
 * Author:      Stephan Kasdorf
 * File:        typeopendiv.php
 * Date:        05.09.20
 */
class TypeOpenAny extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_VALUE            => '',
        self::FORM_ATTRIBUTE_ID     => '',
        self::FORM_ATTRIBUTE_CLASS  => '',
        self::FORM_ATTRIBUTE_ANY    => '',
        self::FORM_ATTRIBUTE_HREF   => ''
    );

    /**
     * @param $attributes
     * @return mixed
     */
    public function loadElement($attributes)
    {
        parent::__construct( $this->_attributes );
        $this->_setElement();
        $this->_setAttributes( self::loadAttributeValues( $attributes ) );
        return $this->getElement();
    }

    /**
     * just the opening div element
     */
    private function _setElement( )
    {
        $this->_element = '<ANY href="HREF" ID CLASS>' . 'VALUE' . "\n";
    }
}
