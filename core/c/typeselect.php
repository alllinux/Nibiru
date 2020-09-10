<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 21:42
 */

class TypeSelect extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_NAME                 => '',
        self::FORM_ATTRIBUTE_CLASS      => '',
        self::FORM_ATTRIBUTE_ID         => '',
        self::FORM_ATTRIBUTE_ONCHANGE   => ''
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
        $this->_element = '<select name="NAME" onchange="ONCHANGE" ID CLASS SELECTED>' . "\n" . 'OPTIONS' . "\n" . '</select>' . "\n";
    }
}