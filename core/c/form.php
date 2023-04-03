<?php
namespace Nibiru\Form;
use Nibiru\Adapter;
/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 20:59
 */

class Form extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_NAME             => '',
        self::FORM_METHOD           => '',
        self::FORM_ACTION           => '',
        self::FORM_TARGET           => '',
        self::FORM_ATTRIBUTE_ID     => '',
        self::FORM_ATTRIBUTE_CLASS  => '',
        self::FORM_ENCTYPE          => '',
        self::FORM_ATTRIBUTE_ONSUBMIT => ''
    );

    public function loadElement( $attributes )
    {
        parent::__construct($this->_attributes);
        $this->_setElement();
        $this->_setAttributes( self::loadAttributeValues( $attributes ) );
        return $this->getElement();
    }

    /**
     * @param mixed $element
     */
    private function _setElement( )
    {
        $this->_element = '<form action="ACTION" method="METHOD" name="NAME" target="TARGET" enctype="ENCTYPE" onsubmit="ONSUBMIT" ID CLASS>' . "\n" . 'FIELDS</form>' . "\n";
    }

}