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
        self::FORM_VALUE                    => '',
        self::FORM_ATTRIBUTE_ID             => '',
        self::FORM_ATTRIBUTE_CLASS          => '',
        self::FORM_ATTRIBUTE_ANY            => '',
        self::FORM_ATTRIBUTE_HREF           => '',
        self::FORM_ATTRIBUTE_SRC            => '',
        self::FORM_ATTRIBUTE_ALT            => '',
        self::FROM_ATTRIBUTE_STYLE          => '',
        self::FORM_ATTRIBUTE_DATA_SITEKEY   => '',
        self::FORM_ATTRIBUTE_TYPE           => '',
        self::FORM_ATTRIBUTE_ROLE           => ''
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
        $this->_element = '<ANY type="TYPE" href="HREF" src="SRC" alt="ALT" style="STYLE" data-sitekey="DATA-SITEKEY" ID CLASS role="ROLE">' . 'VALUE' . "\n";
    }
}
