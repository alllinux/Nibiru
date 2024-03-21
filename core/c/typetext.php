<?php
namespace Nibiru\Form;
use Nibiru\Adapter;

/**
 * Created by PhpStorm.
 * User: mithril
 * Date: 26.01.18
 * Time: 21:42
 */

class TypeText extends FormAttributes implements IForm
{
    private $_attributes = array(
        self::FORM_NAME                     => '',
        self::FORM_VALUE                    => '',
        self::FORM_ATTRIBUTE_SPEECH         => '',
        self::FORM_ATTRIBUTE_ID             => '',
        self::FORM_ATTRIBUTE_CLASS          => '',
        self::FORM_ATTRIBUTE_PLACEHOLDER    => '',
        self::FORM_ATTRIBUTE_REQUIRED       => '',
        self::FORM_ATTRIBUTE_MAXLENGTH      => '',
        self::FORM_ATTRIBUTE_TABINDEX       => '',
        self::FORM_ATTRIBUTE_DISABLED       => '',
        self::FORM_ATTRIBUTE_TS_DECIMALS    => '',
        self::FORM_ATTRIBUTE_TS_STEPS       => ''
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
        $this->_element = '<input type="text" name="NAME" value="VALUE" placeholder="PLACEHOLDER" maxlength="MAXLENGTH" tabindex="TABINDEX" required="REQUIRED" disabled="DISABLED" data-bts-decimals="DATA-BTS-DECIMALS" data-bts-step="DATA-BTS-STEP" SPEECH ID CLASS>' . "\n";
    }
    
    

}